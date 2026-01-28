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
        Schema::create('auditors', function (Blueprint $table) {
            $table->id();

            // Main auditor info
            $table->string('name');
            $table->string('auditor_code')->nullable(); // A.ID
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('photo')->nullable();

            // Existing fields you had
            $table->longText('auditor_details_box')->nullable();
            $table->unsignedInteger('priority')->default(0);

            // Status
            $table->tinyInteger('status')->default(1); // 1=Active, 0=Inactive

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditors');
    }
};
