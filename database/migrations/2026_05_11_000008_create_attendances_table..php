<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {

            $table->id();

            // Site Relation
            $table->foreignId('site_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // Labour Relation
            $table->foreignId('labour_id')
                ->constrained()
                ->onDelete('cascade');

            // Attendance Date
            $table->date('date');

            // Attendance Status
            $table->enum('status', [
                'present',
                'absent',
                'half_day',
                'week_off'
            ])->default('absent');

            // Overtime
            $table->decimal('overtime_hours', 5, 2)
                ->default(0);

            // OT Multiplier
            $table->enum('ot_rate_multiplier', [
                '1',
                '1.5',
                '2'
            ])->default('1');

            // Remarks
            $table->string('remarks')
                ->nullable();

            $table->timestamps();

            // Prevent duplicate attendance
            $table->unique([
                'labour_id',
                'date'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};