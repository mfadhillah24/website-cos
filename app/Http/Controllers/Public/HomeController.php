<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Article;
use App\Models\Division;
use App\Models\Management;
use App\Models\Member;
use App\Models\Period;
use App\Models\Position;
use App\Models\Setting;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Active period
        $activePeriod = Period::where('is_active', true)->first();

        // Statistics
        $stats = [
            'members'    => Member::count(),
            'divisions'  => Division::where('is_active', true)->count(),
            'activities' => Activity::count(),
            'articles'   => Article::where('status', 'published')->count(),
        ];

        // Latest articles (published)
        $latestArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        // Latest activities (for sections)
        $latestActivities = Activity::with('division')
            ->orderByDesc('start_date')
            ->limit(3)
            ->get();

        // Extract photos for hero slideshow from dedicated 'heroheader' folder
        $heroSlideshowPhotos = collect();
        $heroHeaderDir = public_path('images/heroheader');
        if (is_dir($heroHeaderDir)) {
            $files = \Illuminate\Support\Facades\File::files($heroHeaderDir);
            $validExtensions = ['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG', 'WEBP'];
            foreach ($files as $file) {
                if (in_array($file->getExtension(), $validExtensions)) {
                    $heroSlideshowPhotos->push(asset('images/heroheader/' . $file->getFilename()));
                }
            }
        }
        $heroSlideshowPhotos = $heroSlideshowPhotos->values()->all();

        // Upcoming activity for countdown
        // Logic:
        //   - status = 'published'  (only visible/public entries)
        //   - start_date >= today   (hasn't started yet OR starts today)
        //   - order by start_date ASC → pick the nearest one
        $now             = Carbon::now();
        $today           = $now->toDateString();
        $upcomingActivity = Activity::where('status', 'published')
            ->where('start_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->first();

        // Active divisions
        $divisions = Division::where('is_active', true)->limit(6)->get();

        // Core management (active period)
        $coreManagement = collect();
        if ($activePeriod) {
            $coreManagement = Management::with(['member', 'position'])
                ->where('period_id', $activePeriod->id)
                ->where('is_active', true)
                ->orderBy('position_id')
                ->limit(5)
                ->get();
        }

        // Gallery preview
        $galleryPhotos = \App\Models\GalleryPhoto::where('is_published', true)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        // Ketua Umum (jabatan aktif pada periode aktif)
        $ketuaUmum = null;
        if ($activePeriod) {
            $ketuaPosition = Position::where('name', 'like', '%Ketua Umum%')->first();
            if ($ketuaPosition) {
                $ketuaUmum = Management::with(['member', 'period'])
                    ->where('period_id', $activePeriod->id)
                    ->where('position_id', $ketuaPosition->id)
                    ->where('is_active', true)
                    ->first();
            }
        }

        return view('public.home', compact(
            'stats', 'latestArticles', 'latestActivities',
            'divisions', 'coreManagement', 'activePeriod', 'galleryPhotos',
            'ketuaUmum', 'upcomingActivity', 'now', 'heroSlideshowPhotos'
        ));
    }
}
