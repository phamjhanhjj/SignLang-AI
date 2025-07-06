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
        Schema::table('student_topic_record', function (Blueprint $table) {
            $table->integer('current_word')->default(0)->after('is_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_topic_record', function (Blueprint $table) {
            $table->dropColumn('current_word');
        });
    }
};
