<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private function authorizeAccess()
    {
        if (!auth()->user()->can('manage_settings') && !auth()->user()->hasRole('Humas')) {
            abort(403, 'This action is unauthorized.');
        }
    }

    public function index()
    {
        $this->authorizeAccess();
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        $this->authorizeAccess();
        
        if (!$contact->is_read) {
            $contact->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $this->authorizeAccess();
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
