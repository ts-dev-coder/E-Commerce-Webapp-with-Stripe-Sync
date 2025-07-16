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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 20)->unique();
            $table->enum('status', ['pending', 'paid', 'shipped', 'canceled']);
            $table->unsignedInteger('total_price');
            $table->unsignedInteger('shipping_fee')->nullable();
            $table->string('recipient_name', 100);
            $table->string('postal_code', 10);
            $table->string('phone_number', 20);
            $table->dateTime('ordered_at');
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('shipped_at')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('address_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
