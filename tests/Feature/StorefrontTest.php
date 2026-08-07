<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\BlogPost;
use App\Models\Customer;
use App\Models\ImpactMetric;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed minimal data for pages
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
        ]);

        Product::create([
            'name' => 'Eco Diaper Pack M',
            'category' => 'diaper',
            'size' => 'M',
            'price' => 1350,
            'stock' => 20,
            'description' => 'Biodegradable diapers',
            'is_active' => true,
        ]);

        ImpactMetric::create([
            'diapers_saved' => 100,
            'co2_reduced' => 25.5,
            'farmers_supported' => 10,
        ]);

        $customer = Customer::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+254700000000',
            'address' => 'Nairobi',
        ]);

        Testimonial::create([
            'customer_id' => $customer->id,
            'content' => 'Amazing eco diapers!',
            'rating' => 5,
            'approved' => true,
        ]);

        BlogPost::create([
            'title' => 'Eco Parenting Tips',
            'slug' => 'eco-parenting-tips',
            'content' => 'Tips for sustainable parenting.',
            'author_id' => $admin->id,
            'published_at' => now(),
        ]);
    }

    public function test_homepage_renders()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sustainability');
        $response->assertSee('PINACARE');
    }

    public function test_shop_page_renders()
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
        $response->assertSee('Eco Diaper Pack M');
    }

    public function test_shop_category_filter_renders()
    {
        $response = $this->get('/shop?category=diaper');
        $response->assertStatus(200);
        $response->assertSee('Eco Diaper Pack M');
    }

    public function test_product_show_page_renders()
    {
        $product = Product::first();
        $response = $this->get("/shop/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('Add to Cart');
    }

    public function test_about_page_renders()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('Our Story');
    }

    public function test_impact_page_renders()
    {
        $response = $this->get('/impact');
        $response->assertStatus(200);
        $response->assertSee('Diapers Saved');
    }

    public function test_community_page_renders()
    {
        $response = $this->get('/community');
        $response->assertStatus(200);
        $response->assertSee('Eco Parenting Tips');
    }

    public function test_blog_show_renders()
    {
        $response = $this->get('/community/blog/eco-parenting-tips');
        $response->assertStatus(200);
        $response->assertSee('Eco Parenting Tips');
    }

    public function test_partners_page_renders()
    {
        $response = $this->get('/healthcare');
        $response->assertStatus(200);
        $response->assertSee('Healthcare');
    }

    public function test_cart_page_renders()
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertSee('Your cart is empty');
    }

    public function test_checkout_page_redirects_when_cart_empty()
    {
        $response = $this->get('/checkout');
        $response->assertRedirect('/cart');
    }

    public function test_contact_page_renders()
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Contact Us');
    }

    public function test_cart_add_and_checkout_flow()
    {
        $product = Product::first();

        // Add to cart
        $this->post('/cart/add', ['product_id' => $product->id, 'qty' => 1]);
        $this->assertTrue(session()->has('cart'));

        // Cart page shows the product
        $this->get('/cart')->assertSee($product->name);

        // Place order
        $response = $this->post('/checkout', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+254700000000',
            'address' => 'Nairobi, Kenya',
            'payment_method' => 'mpesa',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect();
        $this->assertFalse(session()->has('cart'));
    }
}

