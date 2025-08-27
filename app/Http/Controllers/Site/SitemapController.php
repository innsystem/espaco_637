<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Página inicial
        $sitemap .= $this->addUrl(url('/'), Carbon::now(), 'daily', '1.0');
        
        // Páginas estáticas
        $sitemap .= $this->addUrl(url('/categorias'), Carbon::now(), 'weekly', '0.9');

        // Páginas dinâmicas
        $pages = Page::where('status', 'active')->get();
        foreach ($pages as $page) {
            $sitemap .= $this->addUrl(
                url('/pages/' . $page->slug), 
                $page->updated_at, 
                'monthly', 
                '0.7'
            );
        }

        // Portfólios
        $portfolios = Portfolio::where('status', 1)->get();
        foreach ($portfolios as $portfolio) {
            $sitemap .= $this->addUrl(
                url('/portfolios/' . $portfolio->slug), 
                $portfolio->updated_at, 
                'monthly', 
                '0.7'
            );
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function addUrl($loc, $lastmod, $changefreq, $priority)
    {
        $url = "    <url>\n";
        $url .= "        <loc>" . htmlspecialchars($loc) . "</loc>\n";
        $url .= "        <lastmod>" . $lastmod->toISOString() . "</lastmod>\n";
        $url .= "        <changefreq>" . $changefreq . "</changefreq>\n";
        $url .= "        <priority>" . $priority . "</priority>\n";
        $url .= "    </url>\n";
        
        return $url;
    }
}
