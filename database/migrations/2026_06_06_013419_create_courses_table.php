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
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('instructor_id')->constrained('users')->restrictOnDelete();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->string('cover_image')->nullable();
        $table->enum('level', ['beginner', 'intermediate', 'advanced']);
        $table->boolean('active')->default(true);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
