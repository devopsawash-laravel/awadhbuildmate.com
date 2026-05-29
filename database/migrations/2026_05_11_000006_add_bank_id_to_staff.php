<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {

            $table->unsignedBigInteger('bank_id')
                  ->nullable()
                  ->after('status');

            // Foreign key
            $table->foreign('bank_id')
                  ->references('id')
                  ->on('banks')
                  ->onDelete('set null');
            $table->String('Nominee_details')->nullable()->after('IFSC');
            $table->enum('relation', ['Father', 'Mother', 'Wife','Husband','Son', 'Daughter', 'Brother', 'Sister', 'Guardian'])->nullable()->after('Nominee_details');
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {

            $table->dropForeign(['bank_id']);

            $table->dropColumn('bank_id');
        });
    }
};