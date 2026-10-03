<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Tests\TestCase;

class ProductImageServingTest extends TestCase
{
    use RefreshDatabase;

    /** Mirrors the live data: product 1 uses /storage/products/... */
    public function test_backfill_migration_rewrites_legacy_storage_paths()
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/xcJEG8Up7SiMNNXmqhcIVXlXIUwpjX0s.jpg', 'img');

        $product = Product::create([
            'name' => 'Eco Diaper Pack S', 'slug' => 'eco-diaper-pack-s',
            'category' => 'diaper', 'size' => 'S', 'price' => 780, 'stock' => 0,
            'image_url' => '/storage/products/xcJEG8Up7SiMNNXmqhcIVXlXIUwpjX0s.jpg',
            'is_active' => true,
        ]);

        // RefreshDatabase already applied the migration before this row existed,
        // so replay it directly to prove the rewrite handles existing data.
        $migration = require database_path(
            'migrations/2026_09_10_000000_backfill_product_image_paths_to_media_route.php'
        );

        $migration->up();

        $this->assertSame(
            '/media/products/xcJEG8Up7SiMNNXmqhcIVXlXIUwpjX0s.jpg',
            $product->refresh()->image_url
        );

        // Rollback restores the legacy path.
        $migration->down();

        $this->assertSame(
            '/storage/products/xcJEG8Up7SiMNNXmqhcIVXlXIUwpjX0s.jpg',
            $product->refresh()->image_url
        );
    }

    public function test_backfill_leaves_public_folder_images_untouched()
    {
        $product = Product::create([
            'name' => 'Eco Diaper Pack M', 'slug' => 'eco-diaper-pack-m',
            'category' => 'diaper', 'size' => 'M', 'price' => 684, 'stock' => 40,
            'image_url' => '/Medium (Front view).png',
            'is_active' => true,
        ]);

        $migration = require database_path(
            'migrations/2026_09_10_000000_backfill_product_image_paths_to_media_route.php'
        );
        $migration->up();

        $this->assertSame('/Medium (Front view).png', $product->refresh()->image_url);
    }

    public function test_uploaded_image_is_served_over_http()
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/abc123.png', 'PNGDATA');

        $response = $this->get('/media/products/abc123.png');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');

        // BinaryFileResponse points at the real file on disk.
        $this->assertInstanceOf(BinaryFileResponse::class, $response->baseResponse);
        $this->assertSame(
            Storage::disk('public')->path('products/abc123.png'),
            $response->baseResponse->getFile()->getPathname()
        );
    }

    public function test_missing_file_returns_404()
    {
        Storage::fake('public');

        $this->get('/media/products/nope.png')->assertStatus(404);
    }

    public function test_disallowed_extension_returns_404()
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/evil.php', '<?php');

        $this->get('/media/products/evil.php')->assertStatus(404);
    }

    public function test_path_traversal_is_blocked()
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/ok.png', 'ok');
        // Try to escape the products folder.
        $this->get('/media/products/..%2F..%2F.env')->assertStatus(404);
    }

    public function test_uploading_via_admin_stores_media_path()
    {
        Storage::fake('public');

        $admin = \App\Models\Admin::factory()->create(['password' => bcrypt('password')]);

        $product = Product::create([
            'name' => 'Eco Diaper Pack M', 'slug' => 'eco-diaper-pack-m',
            'category' => 'diaper', 'size' => 'M', 'price' => 684, 'stock' => 40,
            'is_active' => true,
        ]);

        $this->actingAs($admin, 'admin')->put("/admin/products/{$product->slug}", [
            'name'     => $product->name,
            'category' => $product->category,
            'size'     => $product->size,
            'price'    => 684,
            'stock'    => 40,
            'image'    => UploadedFile::fake()->image('new.png', 400, 400),
        ])->assertSessionHasNoErrors();

        $product->refresh();

        $this->assertStringStartsWith('/media/products/', $product->image_url);

        // And it resolves through the new route.
        $this->get($product->image_url)->assertStatus(200);
    }
}