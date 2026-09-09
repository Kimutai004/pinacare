<?php

namespace App\Support;

use App\Models\BlogPost;
use App\Models\Product;

/**
 * Small helpers for on-page SEO: structured data (JSON-LD), meta descriptions
 * and XML escaping for the sitemap.
 *
 * Everything returns plain strings so views can echo them into
 * <script type="application/ld+json"> blocks or meta tags without risk.
 */
class Seo
{
    /**
     * Convert a relative asset path (e.g. "/logo.png") into an absolute URL.
     *
     * @param  string|null  $path
     * @return string
     */
    public static function absolute(string $path = null)
    {
        $path = trim($path ?: '');

        if ($path === '') {
            return request()->schemeAndHttpHost();
        }

        foreach (['http://', 'https://', '//'] as $scheme) {
            if (str_starts_with($path, $scheme)) {
                return $path;
            }
        }

        if (str_starts_with($path, '/')) {
            return request()->schemeAndHttpHost() . $path;
        }

        return request()->schemeAndHttpHost() . '/' . $path;
    }

    /**
     * Build a clean, truncated excerpt for meta descriptions.
     *
     * @param  string|null  $text
     * @param  int          $max
     * @return string
     */
    public static function excerpt(?string $text, int $max = 158)
    {
        if (! $text) {
            return '';
        }

        $text = trim(preg_replace('/\s+/', ' ', $text));

        if (strlen($text) <= $max) {
            return $text;
        }

        $cut = strrpos(substr($text, 0, $max), ' ');

        if ($cut === null || $cut < 60) {
            $cut = $max;
        }

        return substr($text, 0, $cut) . '…';
    }

    /**
     * Escape a value for use inside XML / HTML attribute contexts.
     *
     * @param  string|null  $value
     * @return string
     */
    public static function escapeXml(?string $value)
    {
        if (! $value) {
            return '';
        }

        return str_replace(
            ['&', '<', '>', '"', "'"],
            ['&amp;', '&lt;', '&gt;', '&quot;', '&apos;'],
            $value
        );
    }

    /**
     * Combine multiple JSON-LD documents under a single @graph.
     *
     * @param  array  $graphs  Array of schema.org documents (as PHP arrays)
     * @return string
     */
    public static function graph(array $graphs)
    {
        return json_encode([
            '@context' => 'https://schema.org',
            '@graph'   => $graphs,
        ]);
    }

    /**
     * Product structured data + breadcrumbs.
     *
     * @param  \\Illuminate\\Database\\Eloquent\\Model|Product  $product
     * @return string
     */
    public static function product(Product $product)
    {
        $url   = route('store.product', $product);
        $image = $product->image_url
            ? static::absolute(asset($product->image_url))
            : static::absolute(asset('logo.png'));

        $node = [
            '@type'       => 'Product',
            '@id'         => $url . '#product',
            'url'         => $url,
            'name'        => $product->name,
            'description' => static::excerpt($product->description ?: $product->name),
            'image'       => [$image],
            'brand'       => ['@type' => 'Brand', 'name' => 'PINACARE'],
            'offers'      => [
                '@type'         => 'Offer',
                'url'           => $url,
                'priceCurrency' => 'KES',
                'price'         => $product->price,
                'availability'  => $product->stock > 0
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'itemCondition' => 'https://schema.org/NewCondition',
            ],
        ];

        $crumbs = [
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => request()->root()],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Shop', 'item' => route('store.shop')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $product->name, 'item' => $url],
            ],
        ];

        return static::graph([$node, $crumbs]);
    }

    /**
     * Article structured data for blog posts.
     *
     * @param  \\Illuminate\\Database\\Eloquent\\Model|BlogPost  $post
     * @return string
     */
    public static function article(BlogPost $post)
    {
        $url = route('store.blog', $post->slug);

        $node = [
            '@type'            => 'Article',
            '@id'              => $url . '#article',
            'url'              => $url,
            'headline'         => $post->title,
            'description'      => static::excerpt($post->content),
            'datePublished'    => $post->published_at?->toIso8601String() ?: null,
            'dateModified'     => $post->updated_at?->toIso8601String() ?: null,
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $url],
            'author'           => [
                '@type' => 'Person',
                'name'  => $post->author?->name ?: 'PINACARE Team',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name'  => 'PINACARE',
                'logo'  => [
                    '@type' => 'ImageObject',
                    'url'   => static::absolute(asset('logo.png')),
                ],
            ],
        ];

        return static::graph([$node]);
    }
}