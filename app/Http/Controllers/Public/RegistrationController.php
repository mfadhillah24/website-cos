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

        // Generate base64 logo — wajib agar lolos open_basedir restriction di hosting
        $logoBase64 = null;
        
        // Coba berbagai kemungkinan nama file logo
        $orgLogo = \App\Models\Setting::get('org_logo');
        $candidates = array_filter(array_unique([
            $orgLogo ? 'images/' . $orgLogo : null,
            'images/logo.png',
            'images/logo-cos.png',
            'images/logo_pdf.png',
        ]));

        foreach ($candidates as $candidate) {
            $path = public_path($candidate);
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                if ($data !== false && strlen($data) > 0) {
                    $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    break;
                }
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.registration', [
            'registration' => $registration,
            'logoBase64'   => $logoBase64,
        ])->setOptions([
            'defaultFont'          => 'DejaVu Sans',
            'isRemoteEnabled'      => true,
            'isHtml5ParserEnabled' => true,
        ]);
            
        return $pdf->download('Bukti_Pendaftaran_' . $registration->nim . '.pdf');
    }
}
