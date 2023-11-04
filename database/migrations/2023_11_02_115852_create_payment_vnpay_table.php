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
        Schema::create('payment_vnpay', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id'); // Mã đơn hàng liên kết
            $table->string('vnp_TransactionNo')->nullable(); // Số giao dịch VNPAY
            $table->string('vnp_BankCode')->nullable(); // Mã ngân hàng
            $table->string('vnp_BankTranNo')->nullable(); // Số giao dịch ngân hàng
            $table->string('vnp_CardType')->nullable(); // Loại thẻ
            $table->string('vnp_OrderInfo')->nullable(); // Thông tin đơn hàng
            $table->dateTime('vnp_PayDate')->nullable(); // Ngày và giờ thanh toán
            $table->string('vnp_ResponseCode')->nullable(); // Mã phản hồi
            $table->string('vnp_TmnCode')->nullable(); // Mã website tại VNPAY
            $table->string('vnp_Amount')->nullable(); // Mã website tại VNPAY
            $table->string('vnp_TransactionStatus')->nullable(); // Trạng thái giao dịch
            $table->string('vnp_TxnRef')->nullable(); // Mã tham chiếu
            $table->string('vnp_SecureHash')->nullable(); // Chuỗi bảo mật
            $table->softDeletes();
            $table->timestamps();
            
            // Thêm cột liên kết với bảng Booking
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_vnpay');
    }
};
