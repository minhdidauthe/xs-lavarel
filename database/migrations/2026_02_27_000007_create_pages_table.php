<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();

            $table->string('title', 255);
            $table->string('slug', 280)->unique();
            $table->longText('content');
            $table->longText('rendered_content')->nullable();

            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();

            $table->string('template', 50)->default('default');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
