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
        Schema::create('image_question', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id')->comment('画像ID');
            $table->unsignedBigInteger('question_id')->comment('問題ID');
            $table->timestamps();

            // 外部キー制約を追加
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_question');
    }
};
