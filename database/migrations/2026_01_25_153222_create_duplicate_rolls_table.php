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
    Schema::create('duplicate_rolls', function (Blueprint $table) {
        $table->id();

        $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
        $table->string('roll_number', 50);

        // prevent same roll number repeating for same exam
        $table->unique(['exam_id', 'roll_number']);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duplicate_rolls');
    }
};
