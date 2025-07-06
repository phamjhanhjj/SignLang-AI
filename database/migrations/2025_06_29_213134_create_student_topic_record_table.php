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
        Schema::create('student_topic_record', function (Blueprint $table) {
            // $table->string('student_topic_record_id')->primary();
            $table->string('student_id');
            $table->string('topic_id');
            $table->boolean('is_completed')->default(false);
            $table->integer('current_word')->default(0); // Assuming this is the current word index
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('student')->onDelete('cascade');
            $table->foreign('topic_id')->references('topic_id')->on('topic')->onDelete('cascade');

            // Uncomment the line below if you want to use a primary key
            $table->primary(['student_id', 'topic_id'], 'student_topic_record_primary_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_topic_record', function (Blueprint $table) {
            $table->dropColumn('current_word'); // Remove the current_word column if it exists
        });
          Schema::dropIfExists('student_topic_record');
    }
};
