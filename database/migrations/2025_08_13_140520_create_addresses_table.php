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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('recipient_name', 50); // お届け先氏名

            $table->string('postal_code', 16);     // 例: 1000001, 100-0001 など（バリデーションはアプリ側で）
            $table->string('prefecture', 50);      // 都道府県
            $table->string('city', 100);           // 市区町村（区を含む）
            $table->string('street', 150);         // 町名・丁目・番地・号
            $table->string('building', 150)->nullable(); // 建物名・部屋番号

            $table->string('phone_number', 11); // 電話番号

            $table->boolean('is_default')->default(false); // デフォルトとするかどうかの判定フラグ

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
