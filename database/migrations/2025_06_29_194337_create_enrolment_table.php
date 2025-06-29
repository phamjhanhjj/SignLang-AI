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
        Schema::create('enrolment', function (Blueprint $table) {
            $table->string('enrolment_id')->primary();
            $table->string('course_id');
            $table->string('student_id');
            $table->date('enrolment_datetime');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('course_id')->references('course_id')->on('course')->onDelete('cascade');
            $table->foreign('student_id')->references('student_id')->on('student')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolment');
    }
};
