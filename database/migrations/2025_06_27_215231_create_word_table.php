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
        Schema::create('word', function (Blueprint $table) {
            $table->string('word_id')->primary();
            $table->string('topic_id');
            $table->string('word');
            $table->string('meaning');
            $table->integer('score')->default(0);
            $table->timestamps();

            $table->foreign('topic_id')
                ->references('topic_id')
                ->on('topic')
                ->onDelete('cascade')
                ->onUpdate('cascade'); // Xóa dữ liệu liên quan khi topic bị xóa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word');
    }
};
