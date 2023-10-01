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
        Schema::create('pattern_question', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pattern_id')->comment('パターンID');
            $table->unsignedBigInteger('question_id')->comment('問題ID');
            $table->timestamps();

            // 外部キー制約を追加
            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pattern_question');
    }
};
