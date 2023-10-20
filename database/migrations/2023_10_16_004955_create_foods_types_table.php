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
        Schema::create('foods_types', function (Blueprint $table) {
            $table->id();
            $table->string('parent_id');
            $table->string('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('foods_types');
    }
};
