<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Memorial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate XML sitemap for public memorials';

    public function handle(): int
    {
        $memorials = Memorial::publiclyVisible()->select(['slug', 'updated_at'])->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static pages
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => route('explore'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => route('pricing'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('about'), 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$page['url']}</loc>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        // Memorial pages
        foreach ($memorials as $memorial) {
            $url = route('memorial.show', $memorial->slug);
            $lastmod = $memorial->updated_at->toW3cString();
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url}</loc>\n";
            $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        file_put_contents(public_path('sitemap.xml'), $xml);

        $this->info("Sitemap generated with " . (count($staticPages) + $memorials->count()) . " URLs.");

        return Command::SUCCESS;
    }
}
