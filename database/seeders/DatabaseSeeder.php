<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BlogPost;
use App\Models\Customer;
use App\Models\ImpactMetric;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Testimonial;
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
            ['name' => 'Eco Diaper Pack S', 'category' => 'diaper', 'size' => 'S', 'price' => 1200, 'stock' => 50, 'description' => 'Biodegradable diapers size S', 'image_url' => null, 'is_active' => true],
            ['name' => 'Eco Diaper Pack M', 'category' => 'diaper', 'size' => 'M', 'price' => 1350, 'stock' => 40, 'description' => 'Biodegradable diapers size M', 'image_url' => null, 'is_active' => true],
            ['name' => 'Eco Diaper Pack L', 'category' => 'diaper', 'size' => 'L', 'price' => 1500, 'stock' => 5, 'description' => 'Biodegradable diapers size L', 'image_url' => null, 'is_active' => true],
            ['name' => 'Organic Wipes', 'category' => 'wipe', 'size' => null, 'price' => 450, 'stock' => 100, 'description' => 'Organic baby wipes pack', 'image_url' => null, 'is_active' => true],
            ['name' => 'Starter Bundle', 'category' => 'bundle', 'size' => null, 'price' => 2500, 'stock' => 0, 'description' => 'Complete starter bundle', 'image_url' => null, 'is_active' => true],
        ];

        $products = [];
        foreach ($productsData as $data) {
            $products[] = Product::firstOrCreate(['name' => $data['name']], $data);
        }

        // Customer (idempotent by email)
        $customer = Customer::firstOrCreate(
            ['email' => 'jane@example.com'],
            [
                'name'    => 'Jane Mwangi',
                'phone'   => '+254712345678',
                'address' => 'Nairobi, Kenya',
            ]
        );

        // Only create sample order if the customer has none yet
        if ($customer->orders()->count() === 0) {
            $order = Order::create([
                'customer_id'    => $customer->id,
                'total_amount'   => 2550,
                'status'         => 'delivered',
                'payment_method' => 'mpesa',
            ]);

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $products[0]->id,
                'quantity'   => 1,
                'price'      => 1200,
            ]);
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $products[3]->id,
                'quantity'   => 3,
                'price'      => 450,
            ]);

            Payment::create([
                'order_id'        => $order->id,
                'transaction_id'  => 'MPESA'.time(),
                'amount'          => 2550,
                'status'          => 'success',
                'payment_gateway' => 'mpesa',
            ]);

            Subscription::create([
                'customer_id'        => $customer->id,
                'product_id'         => $products[0]->id,
                'frequency'          => 'weekly',
                'next_delivery_date' => now()->addWeek(),
                'status'             => 'active',
            ]);
        }

        // Impact metrics (single row, idempotent)
        if (ImpactMetric::count() === 0) {
            ImpactMetric::create([
                'diapers_saved'     => 1250,
                'co2_reduced'       => 320.5,
                'farmers_supported' => 45,
            ]);
        }

        // Testimonials (idempotent by content)
        Testimonial::firstOrCreate(
            ['content' => 'These eco diapers are amazing! My baby\'s skin is so much better and they are truly biodegradable.'],
            ['customer_id' => $customer->id, 'rating' => 5, 'approved' => true]
        );
        Testimonial::firstOrCreate(
            ['content' => 'Great quality and fast delivery. Highly recommend to every parent!'],
            ['customer_id' => $customer->id, 'rating' => 4, 'approved' => false]
        );

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

