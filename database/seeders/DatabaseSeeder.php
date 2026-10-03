<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BlogPost;
use App\Models\ImpactMetric;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Default admin account (idempotent)
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@pinacare.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'role'     => 'superadmin',
            ]
        );

        // Products (idempotent by unique name)
        $productsData = [
            ['name' => 'Eco Diaper Pack S', 'slug' => 'eco-diaper-pack-s', 'category' => 'diaper', 'size' => 'S', 'price' => 680, 'stock' => 50, 'description' => 'Biodegradable diapers size S', 'image_url' => '/Small(Front View).png', 'is_active' => true],
            ['name' => 'Eco Diaper Pack M', 'slug' => 'eco-diaper-pack-m', 'category' => 'diaper', 'size' => 'M', 'price' => 684, 'stock' => 40, 'description' => 'Biodegradable diapers size M', 'image_url' => '/Medium (Front view).png', 'is_active' => true],
            ['name' => 'Eco Diaper Pack L', 'slug' => 'eco-diaper-pack-l', 'category' => 'diaper', 'size' => 'L', 'price' => 672, 'stock' => 5, 'description' => 'Biodegradable diapers size L', 'image_url' => '/Large(Front View).png', 'is_active' => true],
            ['name' => 'Organic Wipes', 'slug' => 'organic-wipes', 'category' => 'wipe', 'size' => null, 'price' => 450, 'stock' => 100, 'description' => 'Organic baby wipes pack', 'image_url' => '/Wipes closed.png', 'is_active' => true],
            ['name' => 'Starter Bundle', 'slug' => 'starter-bundle', 'category' => 'bundle', 'size' => null, 'price' => 2500, 'stock' => 0, 'description' => 'Complete starter bundle', 'image_url' => '/Single flat view.png', 'is_active' => true],
        ];

        $products = [];
        foreach ($productsData as $data) {
            $data['slug'] ??= Product::uniqueSlug($data['name']);
            $product = Product::firstOrCreate(['name' => $data['name']], $data);
            if (! $product->image_url && $data['image_url']) {
                $product->update(['image_url' => $data['image_url']]);
            }
            $products[] = $product;
        }

        // Customers, orders, subscriptions and testimonials (idempotent)
        $this->call(CustomerSeeder::class);

        // Impact metrics (single row, idempotent)
        if (ImpactMetric::count() === 0) {
            ImpactMetric::create([
                'diapers_saved'     => 5000,
                'co2_reduced'       => 550,
                'farmers_supported' => 500,
            ]);
        }

        // Blog post (idempotent by slug)
        BlogPost::firstOrCreate(
            ['slug' => 'welcome-to-the-eco-friendly-baby-revolution'],
            [
                'title'        => 'Welcome to the Eco-Friendly Baby Revolution',
                'content'      => 'At PINACARE, we believe every parent can make a difference. Our biodegradable diapers help reduce landfill waste while keeping your baby comfortable. Join our community of eco-conscious parents today!',
                'author_id'    => $admin->id,
                'published_at' => now(),
            ]
        );

$this->command->info('Database seeded successfully!');
    }
}

