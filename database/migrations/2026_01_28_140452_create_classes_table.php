<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();

            $table->string('class_name');              // Class 10
            $table->string('section')->nullable();     // A / B / Science
            $table->string('class_code')->unique();    // CLS-10-A
            $table->string('academic_year')->nullable(); // 2025-2026
            $table->text('description')->nullable();

            $table->tinyInteger('status')->default(1); // 1=Active, 0=Inactive
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
