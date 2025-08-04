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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('stock');

            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();

            $table->dateTime('available_from')->nullable(); // 商品販売日
            $table->dateTime('available_until')->nullable(); // 商品販売終了日
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
