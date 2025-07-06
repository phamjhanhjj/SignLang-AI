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
            // Kiểm tra xem cột current_word đã tồn tại chưa
            if (!Schema::hasColumn('student_topic_record', 'current_word')) {
                $table->integer('current_word')->default(0)->after('is_completed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_topic_record', function (Blueprint $table) {
            // Chỉ xóa nếu cột tồn tại
            if (Schema::hasColumn('student_topic_record', 'current_word')) {
                $table->dropColumn('current_word');
            }
        });
    }
};
