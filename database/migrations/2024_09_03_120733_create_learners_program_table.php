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
        Schema::create('learners_program', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Learners::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Program::class)->constrained('program')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learners_program');
    }
};
