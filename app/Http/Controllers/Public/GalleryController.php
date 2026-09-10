<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = GalleryPhoto::with(['activity', 'division'])
            ->where('is_published', true)
            ->orderByDesc('created_at')
            ->paginate(24);

        return view('public.gallery.index', compact('photos'));
    }
}
