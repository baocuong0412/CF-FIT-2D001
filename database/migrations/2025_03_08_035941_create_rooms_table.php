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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('price', 255);
            $table->unsignedBigInteger('area');
            $table->text('description');
            $table->string('image_logo', 255);
            $table->timestamp('time_start')->useCurrent();
            $table->timestamp('time_end')->useCurrent();
            $table->string('street', 255);
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('new_type_id')->nullable();
            $table->foreign('new_type_id')->references('id')->on('new_type')->onDelete('SET NULL');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('SET NULL');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('SET NULL');
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
