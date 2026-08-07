<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('testimonials', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
        $table->text('content');
        $table->integer('rating')->check('rating BETWEEN 1 AND 5');
        $table->boolean('approved')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
