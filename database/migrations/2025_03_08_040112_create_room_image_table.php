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
        Schema::create('room_image', function (Blueprint $table) {
            $table->id();
            $table->string('image', 255);
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_image');
    }
};
