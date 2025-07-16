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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name', 50);
            $table->string('postal_code', 10);
            $table->string('prefecture', 20);
            $table->string('city', 50);
            $table->string('street', 100);
            $table->string('building', 100)->nullable();
            $table->string('phone_number', 13);
            $table->boolean('is_default')->default(false);
            $table->enum('address_type', ['home', 'work', 'other']);

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
