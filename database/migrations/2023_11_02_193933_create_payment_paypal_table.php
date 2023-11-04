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
        Schema::create('payment_paypal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');  // Thêm trường user_id để liên kết với người dùng
            $table->string('status')->default(2); // Trường để lưu trạng thái đơn đặt hàng
            $table->decimal('total', 10, 2); // Trường giá với 2 số thập phân và tối đa 10 chữ số
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_paypal');
    }
};
