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
    Schema::create('results', function (Blueprint $table) {
        $table->id();

        $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
        $table->string('roll_number', 50);

        $table->unsignedInteger('correct_answer')->default(0);
        $table->unsignedInteger('wrong_answer')->default(0);

        $table->decimal('obtained_mark', 10, 2)->default(0);
        $table->decimal('total_mark', 10, 2)->default(0);
        $table->decimal('pass_mark', 10, 2)->default(0);

        $table->string('status', 10)->default('pending');

        // prevent duplicate result for same exam
        $table->unique(['exam_id', 'roll_number']);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
