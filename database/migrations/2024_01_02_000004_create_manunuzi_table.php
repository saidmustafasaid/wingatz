<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manunuzi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidhaa_id')->constrained('bidhaa')->onDelete('cascade');
            $table->foreignId('msambazaji_id')->nullable()->constrained('wasambazaji')->onDelete('set null');
            $table->unsignedInteger('idadi');
            $table->decimal('bei_ya_kununulia', 12, 2);
            $table->decimal('jumla', 12, 2)->virtualAs('idadi * bei_ya_kununulia');
            $table->date('tarehe');
            $table->text('maelezo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manunuzi');
    }
};
