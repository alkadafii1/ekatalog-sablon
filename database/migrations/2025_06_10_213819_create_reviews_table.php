<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('rating')->nullable(); // Nullable untuk balasan
            $table->text('comment');
            $table->integer('likes_count')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable(); // Untuk relasi balasan
            $table->timestamps();
            
            $table->foreign('parent_id')->references('id')->on('reviews')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};