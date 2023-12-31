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
        Schema::create('daily_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_signups')->default(0);
            $table->integer('google_signups')->default(0);
            $table->integer('facebook_signups')->default(0);
            $table->integer('web_signups')->default(0);
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
        Schema::dropIfExists('daily_statistics');
    }
};
