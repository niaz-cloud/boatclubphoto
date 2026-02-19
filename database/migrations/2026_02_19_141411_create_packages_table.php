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
    Schema::create('packages', function (Blueprint $table) {
        $table->id();

        $table->string('name');                 // Package name
        $table->decimal('price', 10, 2);        // Price
        $table->integer('duration_days');       // 30 / 90 / 365
        $table->text('description')->nullable();// Optional details
        $table->boolean('status')->default(true); // Active / Inactive

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
