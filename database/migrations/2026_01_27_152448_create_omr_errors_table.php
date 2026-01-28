// database/migrations/xxxx_xx_xx_create_omr_errors_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('omr_errors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->string('file_path');
            $table->string('roll_number')->nullable();
            $table->string('set_number')->nullable();
            $table->text('message');
            $table->timestamps();

            $table->foreign('exam_id')
                  ->references('id')
                  ->on('exams')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('omr_errors');
    }
};
