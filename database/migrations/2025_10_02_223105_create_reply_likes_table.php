<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reply_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reply_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['reply_id', 'user_id']); // Prevent duplicate likes
        });
    }

    public function down()
    {
        Schema::dropIfExists('reply_likes');
    }
};