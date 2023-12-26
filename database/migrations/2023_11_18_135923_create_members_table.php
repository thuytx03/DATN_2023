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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('card_number')->nullable();
            $table->string('total_bonus_points')->nullable();
            $table->string('bonus_points_will_be_received')->nullable();
            $table->string('current_bonus_points')->nullable();
            $table->string('points_received_in_batches')->nullable();
            $table->string('total_spending')->nullable();
            $table->string('status')->default(1);
            $table->string('level_id'); // Mức độ thành viên của năm nay
            $table->string('level_id_old')->nullable(); // Mức độ thành viên của năm trước (nullable)
            $table->string('user_id'); // Thêm trường user_id
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('level_id_old')->references('id')->on('membership_levels')->onDelete('cascade');
            // $table->foreign('level_id')->references('id')->on('membership_levels')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
};
