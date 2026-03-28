<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('architect_profiles', function (Blueprint $table) {
            $table->string('timeline')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('architect_profiles', function (Blueprint $table) {
            $table->dropColumn('timeline');
        });
    }
};
