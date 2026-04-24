<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bidhaa', function (Blueprint $table) {
            $table->unsignedInteger('idadi')->default(0)->after('kategoria');
            $table->string('kitengo', 50)->default('kipande')->after('idadi');
            $table->unsignedInteger('idadi_ya_chini')->nullable()->after('kitengo');
            $table->decimal('bei_jumla', 12, 2)->nullable()->after('bei_yangu');
        });
    }

    public function down(): void
    {
        Schema::table('bidhaa', function (Blueprint $table) {
            $table->dropColumn(['idadi', 'kitengo', 'idadi_ya_chini', 'bei_jumla']);
        });
    }
};
