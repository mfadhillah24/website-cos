<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use Illuminate\Http\Request;
use App\Services\NotificationService;

class RegistrationController extends Controller
{
    public function create()
    {
        $divisions = Division::all();
        return view('public.register', compact('divisions'));
    }

    public function store(StoreRegistrationRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/registrations'), $filename);
            $data['photo'] = 'registrations/' . $filename;
        }

        $registration = Registration::create($data);

        NotificationService::sendToRole(
            ['Ketua Umum', 'Sekretaris', 'Humas'],
            'Calon Anggota Baru',
            "{$registration->name} mendaftar sebagai calon anggota baru dan menunggu pemeriksaan.",
            'member_registration',
            route('admin.registrations.show', $registration->id)
        );

        return redirect()->route('register.success')->with('registration_id', $registration->id);
    }

    public function success()
    {
        // For now, we mock the group link. In the future this should be fetched from settings table.
        $whatsappLink = config('app.whatsapp_group_link', 'https://chat.whatsapp.com/dummy');
        $registrationId = session('registration_id');

        return view('public.register-success', compact('whatsappLink', 'registrationId'));
    }

    public function downloadPdf(Registration $registration)
    {
        $registration->load('division');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.registration', compact('registration'));
        return $pdf->download('Bukti_Pendaftaran_' . $registration->nim . '.pdf');
    }
}
