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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('list_seat');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('showtime_id');
            $table->string('email');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->boolean('hasUpdated')->default(0);
            $table->string('price_ticket')->nullable();
            $table->string('price_food')->nullable();
            $table->string('total')->nullable();
            $table->string('payment')->nullable();
            $table->string('status')->nullable();
            $table->longText('note')->nullable();
            $table->longText('cancel_reason')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('bookings');
    }
};
