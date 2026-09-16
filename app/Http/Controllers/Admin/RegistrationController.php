<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Division;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view_registration');

        $query = Registration::with('division')->orderBy('created_at', 'desc');

        // Optional filter example
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }
        if ($request->filled('batch_year')) {
            $query->where('batch_year', $request->batch_year);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        $registrations = $query->paginate(20)->withQueryString();
        $divisions = Division::all();

        return view('admin.registrations.index', compact('registrations', 'divisions'));
    }

    public function show(Registration $registration): View
    {
        $this->authorize('view_registration');
        $registration->load('division');
        return view('admin.registrations.show', compact('registration'));
    }

    public function destroy(Registration $registration)
    {
        $this->authorize('manage_registration');

        if ($registration->photo) {
            \Illuminate\Support\Facades\File::delete(public_path('images/' . $registration->photo));
        }
        $registration->delete();

        return redirect()->route('admin.registrations.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }

    /**
     * Export daftar peserta registrasi online ke PDF.
     * Mendukung filter search, division_id, dan batch_year yang sama dengan halaman index.
     * Digunakan sebagai sumber data integrasi Absensi DIKLAT IT XV.
     */
    public function exportPdf(Request $request)
    {
        $this->authorize('view_registration');

        // Bangun query dengan filter yang sama dengan index()
        $query = Registration::with('division')->orderBy('created_at', 'asc');

        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }
        if ($request->filled('batch_year')) {
            $query->where('batch_year', $request->batch_year);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nim', 'like', '%' . $search . '%');
            });
        }

        $registrations = $query->get();

        // Keterangan filter aktif untuk ditampilkan di PDF
        $filterLabel = $this->buildFilterLabel($request);

        // Nama file otomatis berdasarkan tanggal export
        $filename = 'registrasi-online-cos-' . now()->format('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('pdf.registration_list', compact('registrations', 'filterLabel'))
            ->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    /**
     * Bangun label keterangan filter yang aktif untuk ditampilkan di header PDF.
     */
    private function buildFilterLabel(Request $request): string
    {
        $parts = [];

        if ($request->filled('search')) {
            $parts[] = 'Pencarian: "' . $request->search . '"';
        }
        if ($request->filled('division_id')) {
            $division = Division::find($request->division_id);
            $parts[] = 'Divisi: ' . ($division?->name ?? '-');
        }
        if ($request->filled('batch_year')) {
            $parts[] = 'Angkatan: ' . $request->batch_year;
        }

        return empty($parts) ? 'Semua Peserta' : implode(' | ', $parts);
    }

    /**
     * Export individual registration to PDF.
     */
    public function exportSinglePdf(Registration $registration)
    {
        $this->authorize('view_registration');
        $registration->load('division');

        $pdf = Pdf::loadView('pdf.registration', compact('registration'));
        return $pdf->download('Bukti_Pendaftaran_' . $registration->nim . '.pdf');
    }
}

