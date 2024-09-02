<?php
use App\Models\Learners;
use App\Models\Program;
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
        Schema::create('satisfactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Learners::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Program::class)->constrained('program')->onDelete('cascade');
            $table->morphs('satisfiable');
            $table->unsignedTinyInteger('satisfaction_level'); // 1 for "Very satisfied", 2 for "A little satisfied", 3 for "Not so satisfied", 4 for "Not at all satisfied"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satisfactions');
    }
};
