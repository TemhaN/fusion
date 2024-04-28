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
        Schema::table('actor_films', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });

        Schema::table('category_films', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actor_films', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('category_films', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->timestamps();
        });
    }
};
