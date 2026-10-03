<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard()
    {
        $admin = Admin::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Total Orders');
        $response->assertSee('Revenue');
    }

    public function test_guest_redirected_from_dashboard()
    {
        $response = $this->get('/admin');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_all_admin_pages_render()
    {
        $admin = Admin::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($admin, 'admin');

        $pages = [
            '/admin/products',
            '/admin/products/create',
            '/admin/orders',
            '/admin/subscriptions',
            '/admin/customers',
            '/admin/impact',
            '/admin/blog',
            '/admin/blog/create',
            '/admin/testimonials',
            '/admin/settings',
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);
            $this->assertTrue(
                $response->getStatusCode() == 200,
                "Page {$page} returned status {$response->getStatusCode()}"
            );
        }
    }

    public function test_product_edit_page_renders()
    {
        $admin = Admin::factory()->create([
            'password' => bcrypt('password'),
        ]);
        $product = Product::create([
            'name' => 'Test Diaper',
            'category' => 'diaper',
            'size' => 'M',
            'price' => 500,
            'stock' => 10,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->get("/admin/products/{$product->id}/edit");
        $response->assertStatus(200);
    }

    public function test_editing_a_product_price_keeps_the_existing_image()
    {
        $admin = Admin::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'name' => 'Eco Diaper Pack S',
            'slug' => 'eco-diaper-pack-s',
            'category' => 'diaper',
            'size' => 'S',
            'price' => 680,
            'stock' => 50,
            'image_url' => '/storage/products/existing-photo.png',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->put("/admin/products/{$product->slug}", [
            'name'        => $product->name,
            'category'    => $product->category,
            'size'        => $product->size,
            'price'       => 750,
            'stock'       => $product->stock,
            'description' => $product->description,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.products.index'));

        $product->refresh();

        $this->assertEquals(750, (float) $product->price);
        $this->assertSame('/storage/products/existing-photo.png', $product->image_url);
    }

    public function test_editing_a_product_replaces_the_image_when_a_new_file_is_uploaded()
    {
        Storage::fake('public');

        $admin = Admin::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'name' => 'Eco Diaper Pack M',
            'slug' => 'eco-diaper-pack-m',
            'category' => 'diaper',
            'size' => 'M',
            'price' => 680,
            'stock' => 50,
            'image_url' => '/storage/products/existing-photo.png',
            'is_active' => true,
        ]);

        $newPhoto = UploadedFile::fake()->image('new-photo.png');

        $response = $this->actingAs($admin, 'admin')->put("/admin/products/{$product->slug}", [
            'name'        => $product->name,
            'category'    => $product->category,
            'size'        => $product->size,
            'price'       => 750,
            'stock'       => $product->stock,
            'description' => $product->description,
            'image'       => $newPhoto,
        ]);

        $response->assertSessionHasNoErrors();

        $product->refresh();

        $this->assertNotSame('/storage/products/existing-photo.png', $product->image_url);
        $this->assertStringStartsWith('/media/products/', $product->image_url);
    }

    public function test_uploading_a_new_photo_replaces_the_image_end_to_end()
    {
        Storage::fake('public');

        $admin = Admin::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'name' => 'Eco Diaper Pack S',
            'slug' => 'eco-diaper-pack-s',
            'category' => 'diaper',
            'size' => 'S',
            'price' => 680,
            'stock' => 50,
            'image_url' => '/storage/products/existing-photo.png',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->put("/admin/products/{$product->slug}", [
            '_token'   => 'test-token',
            'name'     => $product->name,
            'category' => $product->category,
            'size'     => $product->size,
            'price'    => 680,
            'stock'    => 50,
            'image'    => UploadedFile::fake()->image('replacement.png', 600, 600),
        ], ['Accept' => 'text/html']);

        // Surface any validation error instead of silently passing.
        $response->assertSessionHasNoErrors();

        $product->refresh();

        $this->assertNotSame('/storage/products/existing-photo.png', $product->image_url);
        $this->assertStringStartsWith('/media/products/', $product->image_url);
    }

    public function test_product_edit_form_has_no_image_url_input()
    {
        $admin = Admin::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'name' => 'Eco Diaper Pack L',
            'slug' => 'eco-diaper-pack-l',
            'category' => 'diaper',
            'size' => 'L',
            'price' => 680,
            'stock' => 50,
            'image_url' => '/storage/products/existing-photo.png',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->get("/admin/products/{$product->slug}/edit");

        $response->assertStatus(200);
        $response->assertDontSee('name="image_url"', false);
        $response->assertSee('name="image"', false);
    }
}
