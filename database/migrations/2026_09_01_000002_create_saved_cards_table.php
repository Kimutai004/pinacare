<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saved_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('stripe_payment_method_id'); // Stripe token
            $table->string('stripe_customer_id'); // Link to Stripe customer
            $table->string('card_brand'); // visa, mastercard, amex, discover
            $table->string('card_last_four', 4); // Last 4 digits
            $table->integer('card_exp_month'); // 1-12
            $table->integer('card_exp_year'); // 2024, 2025, etc
            $table->string('cardholder_name')->nullable();
            $table->boolean('is_default')->default(false); // Default card for quick checkout
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('customer_id');
            $table->index('stripe_payment_method_id');
            $table->unique(['customer_id', 'stripe_payment_method_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_cards');
    }
};
