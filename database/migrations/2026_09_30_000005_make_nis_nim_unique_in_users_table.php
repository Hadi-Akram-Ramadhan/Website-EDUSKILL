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
        // Clean up any duplicate nis_nim values in existing data before creating unique constraint
        $duplicates = DB::table('users')
            ->select('nis_nim', DB::raw('COUNT(*) as count'))
            ->whereNotNull('nis_nim')
            ->where('nis_nim', '!=', '')
            ->groupBy('nis_nim')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            $userRows = DB::table('users')
                ->where('nis_nim', $dup->nis_nim)
                ->orderBy('id')
                ->get();

            // Keep the first record intact, nullify or append suffix to duplicates
            foreach ($userRows->skip(1) as $index => $u) {
                DB::table('users')
                    ->where('id', $u->id)
                    ->update(['nis_nim' => null]);
            }
        }

        try {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('nis_nim');
            });
        } catch (\Throwable $e) {
            // Index already exists or unsupported in testing env
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nis_nim']);
        });
    }
};
