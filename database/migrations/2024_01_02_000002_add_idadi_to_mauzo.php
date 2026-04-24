<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mauzo', function (Blueprint $table) {
            $table->unsignedInteger('idadi')->default(1)->after('bidhaa_id');
        });
    }

    public function down(): void
    {
        Schema::table('mauzo', function (Blueprint $table) {
            $table->dropColumn('idadi');
        });
    }
};
