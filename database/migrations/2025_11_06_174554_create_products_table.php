<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->primary(); // your custom string IDs
            $table->string('category');
            $table->string('color');
            $table->text('description');
            $table->string('name');
            $table->string('image');
            $table->integer('price');
            $table->integer('quantity');
            $table->boolean('isBestSeller')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
