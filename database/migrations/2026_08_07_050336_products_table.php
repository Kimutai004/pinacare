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
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name', 150);
                $table->enum('category', ['diaper','wipe','bundle']);
                $table->enum('size', ['S','M','L'])->nullable();
                $table->decimal('price', 10, 2);
                $table->integer('stock')->default(0);
                $table->text('description')->nullable();
                $table->string('image_url')->nullable();
                $table->boolean('is_active')->default(true);
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
