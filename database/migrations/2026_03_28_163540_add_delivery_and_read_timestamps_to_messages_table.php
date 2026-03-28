<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->timestamp('delivered_at')->nullable()->after('is_read');
            $table->timestamp('read_at')->nullable()->after('delivered_at');
        });

        DB::table('messages')->where('is_read', true)->update([
            'read_at' => DB::raw('updated_at'),
            'delivered_at' => DB::raw('COALESCE(delivered_at, updated_at)'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['delivered_at', 'read_at']);
        });
    }
};
