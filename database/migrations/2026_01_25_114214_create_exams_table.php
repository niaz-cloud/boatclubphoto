<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->unsignedInteger('total_question')->default(0);
            $table->decimal('per_question_mark', 8, 2)->default(1);
            $table->decimal('negative_mark', 8, 2)->default(0);

            $table->unsignedInteger('total_question_set')->default(1);

            $table->decimal('total_mark', 10, 2)->default(0);
            $table->decimal('pass_mark', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
}
