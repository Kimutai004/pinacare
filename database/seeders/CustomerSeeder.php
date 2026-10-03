<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

/**
 * Seeds the shoppers of the store (the `customers` table) together with the
 * related orders, subscriptions and testimonials that hang off them.
 *
 * This is the table the application actually treats as its end users — the
 * stock Laravel `users` table is legacy scaffolding and is left untouched.
 *
 * The seeder is fully idempotent: customers are keyed on email and orders are
 * keyed on the payment `transaction_id`, so running it repeatedly will never
 * create duplicates or wipe edits made through the admin panel.
 */
class CustomerSeeder extends Seeder
{
    /**
     * The shopper profiles to create.
     *
     * `joined_days_ago` backdates `created_at` so the admin "Joined" column
     * shows a believable spread instead of everyone registering today.
     */
    private const CUSTOMERS = [
        ['email' => 'jane@example.com',     'name' => 'Jane Mwangi',   'phone' => '+254712345678', 'address' => 'Nairobi, Kenya', 'joined_days_ago' => 180],
        ['email' => 'serena@example.com',   'name' => 'SERENA',         'phone' => '+254722334455', 'address' => 'Mombasa, Kenya', 'joined_days_ago' => 150],
        ['email' => 'faith@example.com',    'name' => 'Faith Njeri',    'phone' => '+254733445566', 'address' => 'Kisumu, Kenya',  'joined_days_ago' => 120],
        ['email' => 'brian@example.com',    'name' => 'Brian Otieno',   'phone' => '+254744556677', 'address' => 'Nakuru, Kenya',  'joined_days_ago' => 95],
        ['email' => 'aisha@example.com',    'name' => 'Aisha Mohamed',  'phone' => '+254755667788', 'address' => 'Mombasa, Kenya', 'joined_days_ago' => 80],
['email' => 'david@example.com',    'name' => 'David Kimani',   'phone' => '+254766778899', 'address' => 'Nairobi, Kenya', 'joined_days_ago' => 64],
        ['email' => 'grace@example.com',    'name' => 'Grace Wanjiru',  'phone' => '+254777889900', 'address' => 'Kiambu, Kenya',  'joined_days_ago' => 45],
        ['email' => 'peter@example.com',    'name' => 'Peter Mwangi',   'phone' => '+254788990011', 'address' => 'Nyeri, Kenya',   'joined_days_ago' => 30],
        ['email' => 'sarah@example.com',    'name' => 'Sarah Chebet',   'phone' => '+254799001122', 'address' => 'Eldoret, Kenya', 'joined_days_ago' => 18],
        ['email' => 'joseph@example.com',   'name' => 'Joseph Kariuki', 'phone' => '+254701122334', 'address' => 'Thika, Kenya',   'joined_days_ago' => 7],
    ];
/**
     * Orders keyed by the customer's email.
     *
     * `transaction_id` doubles as the idempotency key: an order (and its
     * items/payment) is only created when no payment already carries that
     * reference. `items` are [product_slug, quantity] pairs and the order
     * total is derived from the real product prices so the figures stay
     * internally consistent.
     *
     * Between them these rows give the dashboard a realistic revenue figure
     * and cover every order status the admin filters support.
     */
    private const ORDERS = [
        'jane@example.com' => [
            ['transaction_id' => 'MPESA-8KD2XQ41LM', 'status' => 'delivered', 'payment_method' => 'mpesa', 'days_ago' => 170, 'items' => [['eco-diaper-pack-s', 1], ['organic-wipes', 3]]],
            ['transaction_id' => 'MPESA-3RT9WZ57VN', 'status' => 'delivered', 'payment_method' => 'mpesa', 'days_ago' => 95,  'items' => [['starter-bundle', 1]]],
            ['transaction_id' => 'STRIPE-1PL7AC03MX', 'status' => 'shipped',   'payment_method' => 'card',  'days_ago' => 6,   'items' => [['eco-diaper-pack-m', 2]]],
        ],
        'serena@example.com' => [
            ['transaction_id' => 'MPESA-5YW2NB68KD', 'status' => 'delivered', 'payment_method' => 'mpesa', 'days_ago' => 140, 'items' => [['eco-diaper-pack-l', 1], ['organic-wipes', 2]]],
            ['transaction_id' => 'PAYPAL-9HC4TJ25RB', 'status' => 'paid',      'payment_method' => 'paypal','days_ago' => 12,  'items' => [['eco-diaper-pack-m', 1]]],
        ],
        'faith@example.com' => [
            ['transaction_id' => 'MPESA-2FG7XK91QP', 'status' => 'delivered', 'payment_method' => 'mpesa', 'days_ago' => 110, 'items' => [['starter-bundle', 1]]],
        ],
        'brian@example.com' => [
            ['transaction_id' => 'MPESA-6DJ3PQ74NR', 'status' => 'shipped',         'payment_method' => 'mpesa', 'days_ago' => 20, 'items' => [['eco-diaper-pack-l', 2]]],
            ['transaction_id' => 'MPESA-4NB8ZR16TW', 'status' => 'pending_payment', 'payment_method' => 'mpesa', 'days_ago' => 2,  'items' => [['organic-wipes', 4]]],
        ],
        'aisha@example.com' => [
            ['transaction_id' => 'STRIPE-7KM2VX58LD', 'status' => 'delivered',      'payment_method' => 'card',  'days_ago' => 75, 'items' => [['eco-diaper-pack-m', 1], ['organic-wipes', 2]]],
            ['transaction_id' => 'MPESA-8TQ5WN93HC',  'status' => 'payment_failed', 'payment_method' => 'mpesa', 'days_ago' => 3,  'items' => [['eco-diaper-pack-s', 1]]],
        ],
        'david@example.com' => [
            ['transaction_id' => 'PAYPAL-3XB7LF42RM', 'status' => 'paid', 'payment_method' => 'paypal', 'days_ago' => 9, 'items' => [['starter-bundle', 1]]],
        ],
        'grace@example.com' => [
            ['transaction_id' => 'MPESA-6PK9DM27YB', 'status' => 'pending', 'payment_method' => 'mpesa', 'days_ago' => 1, 'items' => [['eco-diaper-pack-s', 2]]],
        ],
        'peter@example.com' => [
            ['transaction_id' => 'MPESA-1RV6XT84GQ', 'status' => 'delivered', 'payment_method' => 'mpesa', 'days_ago' => 25, 'items' => [['organic-wipes', 3]]],
        ],
        'sarah@example.com' => [
            ['transaction_id' => 'STRIPE-9ZW3MH61LD', 'status' => 'paid', 'payment_method' => 'card', 'days_ago' => 4, 'items' => [['eco-diaper-pack-m', 1], ['eco-diaper-pack-s', 1]]],
        ],
        'joseph@example.com' => [
            ['transaction_id' => 'MPESA-5HJ8NB73WQ', 'status' => 'cancelled', 'payment_method' => 'mpesa', 'days_ago' => 5, 'items' => [['organic-wipes', 1]]],
],
    ];
/**
     * Delivery plans keyed by the customer's email.
     */
    private const SUBSCRIPTIONS = [
        'jane@example.com' => [
            ['product_slug' => 'eco-diaper-pack-s', 'frequency' => 'weekly',   'status' => 'active',    'next_in_days' => 3],
        ],
        'brian@example.com' => [
            ['product_slug' => 'eco-diaper-pack-m', 'frequency' => 'biweekly', 'status' => 'active',    'next_in_days' => 9],
            ['product_slug' => 'organic-wipes',      'frequency' => 'monthly',  'status' => 'paused',    'next_in_days' => 21],
        ],
        'grace@example.com' => [
            ['product_slug' => 'eco-diaper-pack-s', 'frequency' => 'monthly',  'status' => 'active',    'next_in_days' => 18],
        ],
        'serena@example.com' => [
            ['product_slug' => 'eco-diaper-pack-l', 'frequency' => 'monthly',  'status' => 'cancelled', 'next_in_days' => null],
        ],
        'joseph@example.com' => [
            ['product_slug' => 'starter-bundle',    'frequency' => 'biweekly', 'status' => 'active',    'next_in_days' => 6],
        ],
    ];

    /**
     * Reviews left by shoppers, keyed by the customer's email.
     *
     * A few are left unapproved on purpose so the dashboard's "pending
     * review" panel and the admin approvals queue have something to show.
     */
    private const TESTIMONIALS = [
        'jane@example.com' => [
            ['content' => 'These eco diapers are amazing! My baby\'s skin is so much better and they are truly biodegradable.', 'rating' => 5, 'approved' => true],
        ],
        'serena@example.com' => [
            ['content' => 'Great quality and fast delivery. Highly recommend to every parent!', 'rating' => 4, 'approved' => true],
        ],
        'faith@example.com' => [
            ['content' => 'Switching to PINACARE was the best decision for our family — soft, absorbent and truly biodegradable nappies.', 'rating' => 5, 'approved' => true],
        ],
        'aisha@example.com' => [
            ['content' => 'The wipes are gentle and the pack lasts for weeks. Delivery to Mombasa took only two days.', 'rating' => 5, 'approved' => true],
            ['content' => 'Lovely product, though I would love to see a trial pack before committing to the monthly subscription.', 'rating' => 4, 'approved' => false],
        ],
        'david@example.com' => [
            ['content' => 'Ordered the starter bundle and it covered everything we needed for the first month. Very good value.', 'rating' => 4, 'approved' => false],
        ],
        'peter@example.com' => [
            ['content' => 'Customer support sorted out my delivery address change within minutes. Very impressed.', 'rating' => 5, 'approved' => false],
        ],
    ];

    public function run(): void
    {
        $products = Product::all()->keyBy('slug');

        $customers = [];

        foreach (self::CUSTOMERS as $data) {
            $customer = Customer::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'    => $data['name'],
                    'phone'   => $data['phone'],
                    'address' => $data['address'],
                ]
            );

            // Backdate registration the first time the shopper is created so the
            // "Joined" column reflects a believable signup history.
            if ($customer->wasRecentlyCreated) {
                $customer->forceFill([
                    'created_at' => now()->subDays($data['joined_days_ago']),
])->saveQuietly();
            }

            $customers[$data['email']] = $customer;
        }

        $this->seedOrders($customers, $products);
        $this->seedSubscriptions($customers, $products);
        $this->seedTestimonials($customers);

        $this->command->info('Seeded '.count($customers).' customers.');
    }
/**
     * Create orders (plus their line items and payment rows) that have not
     * been created by a previous run.
     */
    private function seedOrders(array $customers, $products): void
    {
        foreach (self::ORDERS as $email => $orders) {
            $customer = $customers[$email] ?? null;

            if (! $customer) {
                continue;
            }

            foreach ($orders as $spec) {
                // The transaction_id is the idempotency key for an order.
                if (Payment::where('transaction_id', $spec['transaction_id'])->exists()) {
                    continue;
                }

                $items = $this->resolveItems($spec['items'], $products);

                if ($items === []) {
                    continue;
                }

                $total = array_sum(array_column($items, 'line_total'));

                $order = Order::create([
                    'customer_id'    => $customer->id,
                    'total_amount'   => $total,
                    'status'         => $spec['status'],
                    'payment_method' => $spec['payment_method'],
                ]);

                $placedAt = now()->subDays($spec['days_ago']);
                $order->forceFill(['created_at' => $placedAt, 'updated_at' => $placedAt])->saveQuietly();

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity'   => $item['quantity'],
                        'price'      => $item['price'],
                    ]);
                }

                Payment::create([
                    'order_id'        => $order->id,
                    'transaction_id'  => $spec['transaction_id'],
                    'amount'          => $total,
                    'status'          => $this->paymentStatusFor($spec['status']),
                    'payment_gateway' => $this->gatewayFor($spec['payment_method']),
                ]);
            }
        }
    }

    /**
     * Create delivery plans that have not been created by a previous run.
     */
    private function seedSubscriptions(array $customers, $products): void
    {
        foreach (self::SUBSCRIPTIONS as $email => $plans) {
            $customer = $customers[$email] ?? null;

            if (! $customer) {
                continue;
            }

            foreach ($plans as $plan) {
                $product = $products[$plan['product_slug']] ?? null;

                if (! $product) {
                    continue;
                }

                $exists = Subscription::where('customer_id', $customer->id)
                    ->where('product_id', $product->id)
                    ->exists();

                if ($exists) {
                    continue;
                }

                Subscription::create([
                    'customer_id'        => $customer->id,
                    'product_id'         => $product->id,
                    'frequency'          => $plan['frequency'],
                    'next_delivery_date' => $plan['next_in_days'] === null
                        ? null
                        : now()->addDays($plan['next_in_days'])->toDateString(),
                    'status'             => $plan['status'],
                ]);
            }
        }
    }

    /**
     * Create reviews that have not been created by a previous run.
     */
    private function seedTestimonials(array $customers): void
    {
        foreach (self::TESTIMONIALS as $email => $reviews) {
            $customer = $customers[$email] ?? null;

            if (! $customer) {
                continue;
            }

            foreach ($reviews as $review) {
                Testimonial::updateOrCreate(
                    ['content' => $review['content']],
                    [
                        'customer_id' => $customer->id,
                        'rating'      => $review['rating'],
                        'approved'    => $review['approved'],
                    ]
                );
            }
        }
    }

    /**
     * Turn [slug, quantity] pairs into order line items, skipping any product
     * that is not currently in the catalogue.
     *
     * @return array<int, array{product_id:int, quantity:int, price:float, line_total:float}>
     */
    private function resolveItems(array $pairs, $products): array
    {
        $items = [];

        foreach ($pairs as [$slug, $quantity]) {
            $product = $products[$slug] ?? null;

            if (! $product) {
                continue;
            }

            $price = (float) $product->price;

            $items[] = [
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'price'      => $price,
                'line_total' => $price * $quantity,
            ];
        }

        return $items;
    }

    /**
     * Map an order status onto the matching payment status.
     */
    private function paymentStatusFor(string $orderStatus): string
    {
        return match ($orderStatus) {
            'delivered', 'shipped', 'paid' => 'success',
            'payment_failed'               => 'failed',
            default                        => 'pending',
        };
    }

    /**
     * Map the order's payment method onto the gateway that processed it.
     * Card payments on this project are handled through Stripe.
     */
    private function gatewayFor(string $paymentMethod): string
    {
        return match ($paymentMethod) {
            'card'   => 'stripe',
            'paypal' => 'paypal',
            default  => 'mpesa',
        };
    }
}
