<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First update old data
        DB::statement("
            UPDATE staff
            SET relation = 'Wife'
            WHERE relation = 'Spouse'
        ");

        // Then update ENUM values
        DB::statement("
            ALTER TABLE staff
            MODIFY relation ENUM(
                'Father',
                'Mother',
                'Wife',
                'Husband',
                'Son',
                'Daughter',
                'Brother',
                'Sister',
                'Guardian'
            ) NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE staff
            MODIFY relation ENUM(
                'Father',
                'Mother',
                'Spouse',
                'Son',
                'Daughter',
                'Brother',
                'Sister',
                'Guardian'
            ) NULL
        ");
    }
};