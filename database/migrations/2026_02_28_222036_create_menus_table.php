<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('url', 500);
            $table->string('icon', 100)->nullable();
            $table->string('css_class', 100)->nullable();
            $table->string('target', 20)->default('_self');
            $table->string('match_pattern', 200)->nullable()->comment('Pattern for active state, e.g. lich-su*');
            $table->foreignId('parent_id')->nullable()->constrained('menus')->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('sort_order');
            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
