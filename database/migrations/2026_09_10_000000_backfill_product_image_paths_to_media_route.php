<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Uploaded product photos used to be linked as /storage/products/<file>,
 * which only resolves when the host exposes storage/app/public through a
 * `storage:link` symlink. They are now streamed through the
 * /media/products/{filename} route, which works on every host.
 *
 * Rewrite existing values so already-uploaded photos keep displaying.
 */
return new class extends Migration
{
    public function up()
    {
        DB::table('products')
            ->whereNotNull('image_url')
            ->where('image_url', 'like', '/storage/products/%')
            ->update([
                'image_url' => DB::raw("REPLACE(image_url, '/storage/products/', '/media/products/')"),
            ]);
    }

    public function down()
    {
        DB::table('products')
            ->whereNotNull('image_url')
            ->where('image_url', 'like', '/media/products/%')
            ->update([
                'image_url' => DB::raw("REPLACE(image_url, '/media/products/', '/storage/products/')"),
            ]);
    }
};