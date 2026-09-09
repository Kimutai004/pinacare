<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            
            $table->text('payment_notes')->nullable()->after('payment_method');
            $table->string('paypal_order_id')->nullable()->after('payment_notes');
            $table->string('stripe_payment_intent_id')->nullable()->after('paypal_order_id');
        });

        $statuses = "'pending', 'pending_payment', 'payment_failed', 'paid', 'shipped', 'delivered', 'refunded', 'cancelled'";
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // On PostgreSQL, enum() columns are stored as varchar with a CHECK
            // constraint. Find the existing status CHECK (whatever its name),
            // drop it, and add the extended one.
            $constraints = DB::select(
                "SELECT conname FROM pg_constraint
                 WHERE conrelid = 'orders'::regclass
                   AND contype = 'c'
                   AND pg_get_constraintdef(oid) ILIKE '%status%'"
            );

            foreach ($constraints as $constraint) {
                DB::statement("ALTER TABLE orders DROP CONSTRAINT IF EXISTS {$constraint->conname}");
            }

            DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ({$statuses}))");
        } else {
            // MySQL / MariaDB: native ENUM column type.
            DB::statement("ALTER TABLE orders MODIFY status ENUM({$statuses}) DEFAULT 'pending'");
        }
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_notes', 'paypal_order_id', 'stripe_payment_intent_id']);
        });
    }
};
