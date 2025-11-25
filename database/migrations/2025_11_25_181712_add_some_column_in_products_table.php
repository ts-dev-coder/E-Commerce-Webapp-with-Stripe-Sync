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
        Schema::table('products', function (Blueprint $table) {
            $table->string('stripe_id');
            $table->string('stripe_price_id');
            $table->string('currency');
            $table->boolean('is_physical')->default(true);
            $table->string('creator');
            $table->string('seo_title');
            $table->string('seo_description');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('stripe_id');
            $table->dropColumn('stripe_price_id');
            $table->dropColumn('currency');
            $table->dropColumn('is_physical');
            $table->dropColumn('creator');
            $table->dropColumn('seo_title');
            $table->dropColumn('seo_description');
            $table->dropColumn('deleted_at');
        });
    }
};
