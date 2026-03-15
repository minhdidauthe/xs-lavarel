<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->string('avatar_color', 7)->default('#3b82f6');
            $table->text('message');
            $table->enum('type', ['user', 'bot', 'system'])->default('user');
            $table->boolean('is_fake')->default(false);
            $table->string('site', 30)->nullable()->comment('soicau24h, soicau7777, or null for both');
            $table->integer('likes')->default(0);
            $table->timestamps();

            $table->index(['created_at', 'site']);
            $table->index('is_fake');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
