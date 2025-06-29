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
        Schema::create('word_practise_video', function (Blueprint $table) {
            $table->string('word_practise_video_id')->primary();
            $table->string('word_id')->nullable();
            $table->string('practise_video_id')->nullable();
            $table->timestamps();

            $table->foreign('word_id')->references('word_id')->on('word')->onDelete('cascade');
            $table->foreign('practise_video_id')->references('practise_video_id')->on('practise_video')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_practise_video');
    }
};
