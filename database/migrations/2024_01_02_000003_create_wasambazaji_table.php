<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wasambazaji', function (Blueprint $table) {
            $table->id();
            $table->string('jina');
            $table->string('simu', 20)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->string('bidhaa_wanazouza')->nullable();
            $table->text('maelezo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wasambazaji');
    }
};
