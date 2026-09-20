<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Setting;
use Carbon\Carbon;

class TerminalController extends Controller
{
    public function activities(Request $request)
    {
        $activities = Activity::where('status', '!=', 'draft')
            ->orderBy('start_date', 'asc')
            ->whereDate('start_date', '>=', Carbon::today())
            ->limit(5)
            ->get();

        $formatted = $activities->map(function ($act) {
            $dateStr = $act->start_date ? $act->start_date->format('d M Y') : 'TBA';
            return [
                'title' => $act->title,
                'date' => $dateStr,
                'location' => $act->location ?? 'TBA',
                'slug' => $act->slug,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formatted
        ]);
    }

    public function kontak()
    {
        // Ambil nilai dari tabel settings
        $instagramUrl = Setting::get('instagram_link', '');
        $email        = Setting::get('email_contact', '');
        $whatsapp     = Setting::get('whatsapp_group_link', '');
        $address      = Setting::get('address', '');

        // Bersihkan URL Instagram menjadi username saja
        $instagramHandle = $instagramUrl
            ? '@' . ltrim(rtrim(parse_url($instagramUrl, PHP_URL_PATH), '/'), '/')
            : '-';

        return response()->json([
            'success' => true,
            'data' => [
                'instagram' => $instagramHandle,
                'email'     => $email ?: '-',
                'whatsapp'  => $whatsapp ?: '-',
                'address'   => $address ?: '-',
            ]
        ]);
    }

    public function about()
    {
        $description = Setting::get('org_description', 'Cyber Open Source (COS) adalah wadah bagi mahasiswa untuk belajar teknologi, mengembangkan kreativitas, membangun kolaborasi, dan menciptakan solusi digital melalui semangat Open Source.');
        
        return response()->json([
            'success' => true,
            'data' => $description
        ]);
    }
}
