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
        Schema::create('articles', function (Blueprint $table) {
           $table->id();
        $table->unsignedBigInteger('devto_id')->unique();
        $table->string('title');
        $table->string('url');
        $table->text('description')->nullable();
        $table->json('tags')->nullable();
        $table->integer('public_reactions_count')->default(0);
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
