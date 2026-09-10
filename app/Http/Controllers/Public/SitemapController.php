<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Activity;
use App\Models\Division;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap for public pages.
     * Includes static routes + dynamic article, activity, and division URLs.
     */
    public function index(): Response
    {
        $baseUrl = 'https://cyberopensource.rf.gd';

        // Static public pages
        $staticUrls = [
            ['loc' => $baseUrl . '/',           'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/tentang',     'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/organisasi',  'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/divisi',      'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/kegiatan',    'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/berita',      'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/galeri',      'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/kontak',      'priority' => '0.6', 'changefreq' => 'yearly'],
        ];

        // Dynamic: Published Articles / Berita
        $articles = collect();
        try {
            $articles = Article::whereNotNull('slug')
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->get(['slug', 'updated_at', 'published_at']);
        } catch (\Exception $e) {
            // Table may not exist in all environments — fail silently
        }

        // Dynamic: Activities / Kegiatan (no published_status on this model)
        $activities = collect();
        try {
            $activities = Activity::whereNotNull('slug')
                ->orderByDesc('start_date')
                ->get(['slug', 'updated_at', 'start_date']);
        } catch (\Exception $e) {
            // Fail silently
        }

        // Dynamic: Divisions / Divisi
        $divisions = collect();
        try {
            $divisions = Division::whereNotNull('slug')
                ->get(['slug', 'updated_at']);
        } catch (\Exception $e) {
            // Fail silently
        }

        $xml = $this->buildXml($baseUrl, $staticUrls, $articles, $activities, $divisions);

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Build the XML sitemap string.
     */
    private function buildXml(string $baseUrl, array $staticUrls, $articles, $activities, $divisions): string
    {
        $lines = [];
        $lines[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $lines[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Static pages
        foreach ($staticUrls as $url) {
            $lines[] = '  <url>';
            $lines[] = '    <loc>' . $url['loc'] . '</loc>';
            $lines[] = '    <changefreq>' . $url['changefreq'] . '</changefreq>';
            $lines[] = '    <priority>' . $url['priority'] . '</priority>';
            $lines[] = '  </url>';
        }

        // Articles
        foreach ($articles as $article) {
            $lastmod = ($article->updated_at ?? $article->published_at)?->toAtomString();
            $lines[] = '  <url>';
            $lines[] = '    <loc>' . $baseUrl . '/berita/' . e($article->slug) . '</loc>';
            if ($lastmod) {
                $lines[] = '    <lastmod>' . $lastmod . '</lastmod>';
            }
            $lines[] = '    <changefreq>monthly</changefreq>';
            $lines[] = '    <priority>0.7</priority>';
            $lines[] = '  </url>';
        }

        // Activities
        foreach ($activities as $activity) {
            $lastmod = ($activity->updated_at ?? $activity->start_date)?->toAtomString();
            $lines[] = '  <url>';
            $lines[] = '    <loc>' . $baseUrl . '/kegiatan/' . e($activity->slug) . '</loc>';
            if ($lastmod) {
                $lines[] = '    <lastmod>' . $lastmod . '</lastmod>';
            }
            $lines[] = '    <changefreq>monthly</changefreq>';
            $lines[] = '    <priority>0.7</priority>';
            $lines[] = '  </url>';
        }

        // Divisions
        foreach ($divisions as $division) {
            $lastmod = $division->updated_at?->toAtomString();
            $lines[] = '  <url>';
            $lines[] = '    <loc>' . $baseUrl . '/divisi/' . e($division->slug) . '</loc>';
            if ($lastmod) {
                $lines[] = '    <lastmod>' . $lastmod . '</lastmod>';
            }
            $lines[] = '    <changefreq>monthly</changefreq>';
            $lines[] = '    <priority>0.6</priority>';
            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines);
    }
}
