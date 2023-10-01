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
        Schema::create('answer_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('answer_id')->comment('正答ID');
            $table->unsignedBigInteger('image_id')->comment('画像ID');
            $table->timestamps();

            // 外部キー制約を追加
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_image');
    }
};
