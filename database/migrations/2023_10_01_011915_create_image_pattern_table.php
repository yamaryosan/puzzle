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
        Schema::create('image_pattern', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id')->comment('画像ID');
            $table->unsignedBigInteger('pattern_id')->comment('パターンID');
            $table->timestamps();

            // 外部キー制約を追加
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_pattern');
    }
};
