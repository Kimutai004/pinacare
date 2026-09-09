<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Product;
use App\Support\Seo;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate an XML sitemap for search engines.
     *
     * @return \\Illuminate\\Http\\Response
     */
    public function index()
    {
        $baseUrl = request()->root();
        $urls = [];

        // Static pages
        $static = [
            ['loc' => $baseUrl . '/',                         'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => $baseUrl . '/shop',                     'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => $baseUrl . '/about',                    'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/impact',                   'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/community',                'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/healthcare',               'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/contact',                  'priority' => '0.4', 'changefreq' => 'yearly'],
        ];

        foreach ($static as $row) {
            $urls[] = $row + ['lastmod' => now()->toDateString()];
        }

        // Products
        Product::where('is_active', true)->chunk(200, function ($products) use (&$urls) {
            foreach ($products as $product) {
                $urls[] = [
                    'loc'        => route('store.product', $product),
                    'lastmod'    => $product->updated_at?->toDateString() ?: now()->toDateString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.8',
                ];
            }
        });

        // Blog posts
        BlogPost::whereNotNull('published_at')->chunk(200, function ($posts) use (&$urls) {
            foreach ($posts as $post) {
                $urls[] = [
                    'loc'        => route('store.blog', $post->slug),
                    'lastmod'    => $post->updated_at?->toDateString() ?: now()->toDateString(),
                    'changefreq' => 'monthly',
                    'priority'   => '0.6',
                ];
            }
        });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . Seo::escapeXml($url['loc']) . "</loc>\n";
            $xml .= '    <lastmod>' . Seo::escapeXml($url['lastmod']) . "</lastmod>\n";
            $xml .= '    <changefreq>' . Seo::escapeXml($url['changefreq']) . "</changefreq>\n";
            $xml .= '    <priority>' . Seo::escapeXml($url['priority']) . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>' . "\n";

        return new Response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}