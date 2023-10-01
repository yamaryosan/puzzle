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
        Schema::create('hint_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id')->comment('画像ID');
            $table->unsignedBigInteger('hint_id')->comment('ヒントID');
            $table->timestamps();

            // 外部キー制約を追加
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->foreign('hint_id')->references('id')->on('hints')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hint_image');
    }
};
