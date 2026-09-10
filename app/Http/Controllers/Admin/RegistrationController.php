<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Division;
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
}
