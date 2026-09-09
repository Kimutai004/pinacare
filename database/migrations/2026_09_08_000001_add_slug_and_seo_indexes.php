<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

/**
 * SEO & performance upgrade:
 *  - adds a unique URL slug to products (SEO friendly product URLs)
 *  - adds composite indexes used by storefront queries
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug', 160)->nullable()->after('name');
        });

        // Backfill slugs for any existing products (idempotent)
        $products = Product::query()->whereNull('slug')->get();

        foreach ($products as $product) {
            $product->update(['slug' => Product::uniqueSlug($product->name, $product->id)]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->unique('slug');
            $table->index(['is_active', 'category']);
            $table->index(['is_active', 'size']);
            $table->index(['is_active', 'created_at']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index('published_at');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->index('approved');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('product_id');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_slug_unique');
            $table->dropIndex(['is_active', 'category']);
            $table->dropIndex(['is_active', 'size']);
            $table->dropIndex(['is_active', 'created_at']);
            $table->dropColumn('slug');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex('blog_posts_published_at_index');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex('testimonials_approved_index');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex('order_items_order_id_index');
            $table->dropIndex('order_items_product_id_index');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('payments_order_id_index');
        });
    }
};