<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinanceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FinanceCategoryController extends Controller
{
    public function index(): View
    {
        $this->authorize('view_finance');

        $categories = FinanceCategory::withCount('finances')->orderBy('type')->get();
        return view('admin.finance_categories.index', compact('categories'));
    }

    public function create(): View
    {
        $this->authorize('manage_finance');

        return view('admin.finance_categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('manage_finance');

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'type'        => ['required', 'in:income,expense'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        FinanceCategory::create($data);
        return redirect()->route('admin.finance-categories.index')
            ->with('success', 'Kategori keuangan berhasil ditambahkan.');
    }

    public function edit(FinanceCategory $financeCategory): View
    {
        $this->authorize('manage_finance');

        return view('admin.finance_categories.edit', compact('financeCategory'));
    }

    public function update(Request $request, FinanceCategory $financeCategory): RedirectResponse
    {
        $this->authorize('manage_finance');

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'type'        => ['required', 'in:income,expense'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $financeCategory->update($data);
        return redirect()->route('admin.finance-categories.index')
            ->with('success', 'Kategori keuangan berhasil diperbarui.');
    }

    public function destroy(FinanceCategory $financeCategory): RedirectResponse
    {
        $this->authorize('manage_finance');

        if ($financeCategory->finances()->count() > 0) {
            return back()->with('error', 'Kategori ini tidak dapat dihapus karena sudah memiliki transaksi.');
        }
        $financeCategory->delete();
        return redirect()->route('admin.finance-categories.index')
            ->with('success', 'Kategori keuangan berhasil dihapus.');
    }
}
