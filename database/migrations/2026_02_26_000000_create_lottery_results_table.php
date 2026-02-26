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
        Schema::create('lottery_results', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('region', 5);
            $table->string('province', 100);
            $table->json('prizes');
            $table->json('numbers');
            $table->string('source', 100)->default('xskt.com.vn');
            $table->timestamps();

            $table->unique(['date', 'region', 'province'], 'unique_result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lottery_results');
    }
};
