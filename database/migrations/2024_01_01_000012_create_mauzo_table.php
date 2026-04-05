<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mauzo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidhaa_id')->constrained('bidhaa')->onDelete('cascade');
            $table->foreignId('mteja_id')->constrained('wateja')->onDelete('cascade');
            $table->decimal('bei_halisi', 12, 2);
            $table->decimal('bei_iliyouzwa', 12, 2);
            $table->decimal('faida', 12, 2);
            $table->integer('siku_za_kuuza')->nullable()->comment('Siku zilizopita tangu bidhaa liwekwa mpaka kuuza');
            $table->text('maelezo')->nullable();
            $table->date('tarehe_ya_uuzaji');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mauzo');
    }
};
