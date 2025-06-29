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
        Schema::create('student_word_record', function (Blueprint $table) {
            $table->string('student_word_record_id')->primary();
            $table->string('student_id');
            $table->string('word_id');
            $table->boolean('is_learned')->default(false);
            $table->integer('replay_time')->default(0);
            $table->boolean('is_mastered')->default(false);
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('student')->onDelete('cascade');
            $table->foreign('word_id')->references('word_id')->on('word')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_word_record');
    }
};
