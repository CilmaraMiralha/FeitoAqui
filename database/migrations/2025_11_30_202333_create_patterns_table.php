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
        Schema::create('patterns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('original_pattern_id')->nullable()->constrained('patterns')->onDelete('set null');
            $table->string('name');
            $table->text('description');
            $table->string('language')->default('pt-BR');
            $table->decimal('price', 10, 2);
            $table->json('tags')->nullable();
            $table->json('photos')->nullable();
            $table->string('attachment')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patterns');
    }
};
