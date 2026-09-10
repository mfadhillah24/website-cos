<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class AboutController extends Controller
{
    public function index()
    {
        $settings = [
            'org_name'        => Setting::get('org_name', 'UKM-IT Cyber Open Source'),
            'org_description' => Setting::get('org_description', 'Unit Kegiatan Mahasiswa Ilmu Teknologi & Coding Student'),
            'org_vision'      => Setting::get('org_vision'),
            'org_mission'     => Setting::get('org_mission'),
            'org_history'     => Setting::get('org_history'),
            'org_founded'     => Setting::get('org_founded'),
        ];

        return view('public.about', compact('settings'));
    }
}
