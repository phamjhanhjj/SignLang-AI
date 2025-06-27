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
        Schema::create('topic', function (Blueprint $table) {
            $table->string('topic_id')->primary();
            $table->string('course_id');
            $table->string('name');
            $table->integer('level')->default(1);
            $table->integer('number_of_word')->default(0);
            $table->timestamps();

            $table->foreign('course_id')
                ->references('course_id')
                ->on('course')
                ->onDelete('cascade')
                ->onUpdate('cascade'); // Xóa dữ liệu liên quan khi course bị xóa

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic');
    }
};
