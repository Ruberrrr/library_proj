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
        Schema::create('books', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->string('author');
            $table->timestamps();
            $table->boolean('is_reserved')->default(false);
            $table->foreignId('reserved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('give')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};