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
            $table->integer('total_bonus_points')->nullable();
            $table->integer('bonus_points_will_be_received')->nullable();
            $table->integer('current_bonus_points')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('level_id'); // Mức độ thành viên của năm nay
            $table->unsignedBigInteger('level_id_old')->nullable(); // Mức độ thành viên của năm trước (nullable)
            $table->unsignedBigInteger('user_id'); // Thêm trường user_id
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('level_id_old')->references('id')->on('membership_levels')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('membership_levels')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
