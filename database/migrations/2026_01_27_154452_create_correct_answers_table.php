<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('correct_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->string('set_number');          // A, B, 1, 2 etc
            $table->unsignedInteger('question_number');
            $table->string('student_option');      // A/B/C/D (answer key option)
            $table->timestamps();

            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');

            // ✅ prevent duplicate key rows for same exam+set+question
            $table->unique(['exam_id', 'set_number', 'question_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('correct_answers');
    }
};
