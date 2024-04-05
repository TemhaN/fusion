<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToCategoryFilmsTable extends Migration
{
    public function up()
    {
        Schema::table('category_films', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('category_films', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
}

