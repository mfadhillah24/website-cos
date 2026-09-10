<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('public.contact');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($validated);

        NotificationService::sendToRole(
            'Humas',
            'Pesan Publik Baru',
            "Pesan baru dari {$contact->name} melalui halaman Kontak.",
            'public_message',
            route('admin.contacts.show', $contact->id)
        );

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}
