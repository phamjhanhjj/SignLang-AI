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
        Schema::create('student_practise_video_record', function (Blueprint $table) {
            $table->string('student_practise_video_record_id')->primary();
            $table->string('student_id');
            $table->string('practise_video_id');
            $table->boolean('is_learned')->default(false);
            $table->integer('replay_time')->default(0);
            $table->boolean('is_mastered')->default(false);
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('student')->onDelete('cascade');
            $table->foreign('practise_video_id')->references('practise_video_id')->on('practise_video')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_practise_video_record');
    }
};
