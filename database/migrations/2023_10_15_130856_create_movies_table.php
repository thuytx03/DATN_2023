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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('language');
            $table->string('poster');
            $table->string('trailer');
            $table->string('director')->nullable();
            $table->string('actor')->nullable();
            $table->string('manufacturer');
            $table->string('duration');
            $table->dateTime('start_date');
            $table->integer('view')->default(0);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->tinyInteger('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('country')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
};
