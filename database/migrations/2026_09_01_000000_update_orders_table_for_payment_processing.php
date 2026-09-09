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

        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'pending_payment', 'payment_failed', 'paid', 'shipped', 'delivered', 'refunded', 'cancelled') DEFAULT 'pending'");
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_notes', 'paypal_order_id', 'stripe_payment_intent_id']);
        });
    }
};
