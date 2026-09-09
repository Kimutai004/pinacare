<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['name','category','size','price','stock','description','image_url','slug','is_active'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Use the SEO-friendly slug when generating URLs & resolving route bindings.
     * Falls back to the primary key (id) when the slug is empty so URLs still
     * work before the migration backfills slugs.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Return the route key value, falling back to the primary key when the
     * slug has not been set yet.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        $slug = $this->getAttribute('slug');

        if ($slug === null || $slug === '') {
            return $this->getKey();
        }

        return $slug;
    }

    /**
     * Generate a unique URL slug for a product name.
     *
     * @param  string      $base       The base string (usually the product name)
     * @param  int|null    $ignoreId   Product id to exclude from uniqueness checks
     * @return string
     */
    public static function uniqueSlug(string $base, ?int $ignoreId = null)
    {
        $slug = Str::slug($base);
        $candidate = $slug;
        $i = 2;

        while (Product::where('slug', $candidate)
            ->when($ignoreId !== null, fn($query) => $query->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $candidate = $slug . '-' . $i;
            $i++;
        }

        return $candidate;
    }
}
