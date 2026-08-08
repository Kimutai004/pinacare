<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
