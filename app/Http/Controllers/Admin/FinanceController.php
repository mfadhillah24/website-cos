<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\FinanceCategory;
use App\Models\Management;
use App\Models\Period;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Services\NotificationService;
use App\Models\Rab;

class FinanceController extends Controller
{
    /**
     * Bangun query Finance dengan filter period_id (aktif), month, dan year.
     * month harus 1-12, year harus 4 digit; nilai tidak valid diabaikan.
     *
     * @return array{query: \Illuminate\Database\Eloquent\Builder, filterMonth: int|null, filterYear: int|null, periodLabel: string}
     */
    private function buildFinanceQuery(Request $request, string $order = 'desc'): array
    {
        $activePeriod = Period::where('is_active', true)->first();

        // Validasi & sanitasi parameter
        $rawMonth = $request->query('month');
        $rawYear  = $request->query('year');

        $filterMonth = (is_numeric($rawMonth) && $rawMonth >= 1 && $rawMonth <= 12)
            ? (int) $rawMonth
            : null;

        $filterYear = (is_numeric($rawYear) && strlen((string)(int)$rawYear) === 4)
            ? (int) $rawYear
            : null;

        $query = Finance::with(['category', 'period'])->orderBy('date', $order);

        if ($activePeriod) {
            $query->where('period_id', $activePeriod->id);
        }

        if ($filterMonth) {
            $query->whereMonth('date', $filterMonth);
        }

        if ($filterYear) {
            $query->whereYear('date', $filterYear);
        }

        // Buat label periode yang akan ditampilkan di halaman & PDF
        $bulanNama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        if ($filterMonth && $filterYear) {
            $periodLabel = $bulanNama[$filterMonth] . ' ' . $filterYear;
        } elseif ($filterMonth) {
            $periodLabel = $bulanNama[$filterMonth];
        } elseif ($filterYear) {
            $periodLabel = 'Tahun ' . $filterYear;
        } else {
            $periodLabel = 'Semua Periode';
        }

        return compact('query', 'filterMonth', 'filterYear', 'periodLabel', 'activePeriod');
    }

    public function index(Request $request): View
    {
        $this->authorize('view_finance');

        [
            'query'       => $query,
            'filterMonth' => $filterMonth,
            'filterYear'  => $filterYear,
            'periodLabel' => $periodLabel,
            'activePeriod'=> $activePeriod,
        ] = $this->buildFinanceQuery($request, 'desc');

        $finances = $query->get();

        $totalIncome  = $finances->where('type', 'income')->sum('amount');
        $totalExpense = $finances->where('type', 'expense')->sum('amount');
        $balance      = $totalIncome - $totalExpense;

        // Statistik RAB tetap berdasarkan periode aktif saja (tidak dipengaruhi filter bulan)
        $rabsQuery = Rab::query();
        if ($activePeriod) {
            $rabsQuery->where('period_id', $activePeriod->id);
        }
        $rabsData = $rabsQuery->with('items')->get();
        $rabCount = $rabsData->count();
        $rabDraftCount = $rabsData->where('status', 'draft')->count();
        $rabFinalCount = $rabsData->where('status', 'final')->count();
        $rabTotalBudget = $rabsData->sum(function ($rab) {
            return $rab->items->sum('subtotal');
        });

        return view('admin.finances.index', compact(
            'finances', 'activePeriod', 'totalIncome', 'totalExpense', 'balance',
            'rabCount', 'rabDraftCount', 'rabFinalCount', 'rabTotalBudget',
            'filterMonth', 'filterYear', 'periodLabel'
        ));
    }

    public function create(): View
    {
        $this->authorize('manage_finance');

        $activePeriod = Period::where('is_active', true)->firstOrFail();
        $categories   = FinanceCategory::orderBy('type')->orderBy('name')->get();
        return view('admin.finances.create', compact('activePeriod', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('manage_finance');

        $activePeriod = Period::where('is_active', true)->firstOrFail();

        $data = $request->validate([
            'category_id' => ['required', 'exists:finance_categories,id'],
            'date'        => ['required', 'date'],
            'description' => ['required', 'string', 'max:500'],
            'amount'      => ['required', 'integer', 'min:1'],
            'type'        => ['required', 'in:income,expense'],
            'receipt'     => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $data['period_id'] = $activePeriod->id;

        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')->store('receipts', 'public');
        }
        unset($data['receipt']);
        $finance = Finance::create($data);

        NotificationService::sendToRole(
            'Bendahara',
            'Transaksi Keuangan Baru',
            "Terdapat transaksi keuangan baru sebesar Rp" . number_format($finance->amount, 0, ',', '.') . " untuk {$finance->description}.",
            'finance_submission',
            route('admin.finances.index')
        );

        return redirect()->route('admin.finances.index')
            ->with('success', 'Transaksi keuangan berhasil ditambahkan.');
    }

    public function edit(Finance $finance): View
    {
        $this->authorize('manage_finance');

        $categories = FinanceCategory::orderBy('type')->orderBy('name')->get();
        return view('admin.finances.edit', compact('finance', 'categories'));
    }

    public function update(Request $request, Finance $finance): RedirectResponse
    {
        $this->authorize('manage_finance');

        $data = $request->validate([
            'category_id' => ['required', 'exists:finance_categories,id'],
            'date'        => ['required', 'date'],
            'description' => ['required', 'string', 'max:500'],
            'amount'      => ['required', 'integer', 'min:1'],
            'type'        => ['required', 'in:income,expense'],
            'receipt'     => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        if ($request->hasFile('receipt')) {
            // Delete old receipt if exists
            if ($finance->receipt_path) {
                Storage::disk('public')->delete($finance->receipt_path);
            }
            $data['receipt_path'] = $request->file('receipt')->store('receipts', 'public');
        }
        unset($data['receipt']);

        $finance->update($data);
        return redirect()->route('admin.finances.index')
            ->with('success', 'Transaksi keuangan berhasil diperbarui.');
    }

    public function destroy(Finance $finance): RedirectResponse
    {
        $this->authorize('manage_finance');

        if ($finance->receipt_path) {
            Storage::disk('public')->delete($finance->receipt_path);
        }
        $finance->delete();
        return redirect()->route('admin.finances.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    public function exportPdf(Request $request): Response
    {
        $this->authorize('view_finance');

        [
            'query'       => $query,
            'filterMonth' => $filterMonth,
            'filterYear'  => $filterYear,
            'periodLabel' => $periodLabel,
            'activePeriod'=> $activePeriod,
        ] = $this->buildFinanceQuery($request, 'asc');

        $finances     = $query->get();
        $totalIncome  = $finances->where('type', 'income')->sum('amount');
        $totalExpense = $finances->where('type', 'expense')->sum('amount');
        $balance      = $totalIncome - $totalExpense;

        // Query Bendahara Umum & Ketua Umum dari pengurus aktif
        $managementQuery = Management::with(['member', 'position'])
            ->where('is_active', true);
        if ($activePeriod) {
            $managementQuery->where('period_id', $activePeriod->id);
        }
        $managements = $managementQuery->get();

        $bendaharaUmum = $managements->first(function ($m) {
            return $m->position && stripos($m->position->name, 'Bendahara') !== false
                && stripos($m->position->name, 'Anggota') === false;
        });
        $ketuaUmum = $managements->first(function ($m) {
            return $m->position && stripos($m->position->name, 'Ketua Umum') !== false;
        });

        // Nama file PDF mencerminkan filter yang aktif
        $fileSuffix = $filterMonth && $filterYear
            ? $filterYear . '-' . str_pad($filterMonth, 2, '0', STR_PAD_LEFT)
            : now()->format('Y-m-d');

        $pdf = Pdf::loadView('admin.finances.pdf', compact(
            'finances', 'activePeriod', 'totalIncome', 'totalExpense', 'balance',
            'bendaharaUmum', 'ketuaUmum', 'filterMonth', 'filterYear', 'periodLabel'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-keuangan-' . $fileSuffix . '.pdf');
    }
}
