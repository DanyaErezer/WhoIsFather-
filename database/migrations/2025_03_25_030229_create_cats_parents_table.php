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
        Schema::create('cats_parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kitten_id')->constrained('cats')->onDelete('cascade');
            $table->foreignId('mother_id')->constrained('cats')->onDelete('cascade');
            $table->foreignId('father_id')->nullable()->constrained('cats')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats_parents');
    }
};
