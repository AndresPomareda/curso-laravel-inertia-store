<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('slug',255);
            $table->string('date')->default(Carbon::now());
            $table->string('image',260)->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->enum('posted',['yes','not'])->default('not');
            $table->enum('type',['adverd','post','movie','course'])->default('post');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
