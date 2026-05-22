<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('labours', function (Blueprint $table) {

            $table->id();

            // Site Relation
            $table->foreignId('site_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // Project Relation
            $table->foreignId('project_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // Basic Details
            $table->string('name')->nullable();

            $table->string('employee_id')
                ->unique()
                ->nullable();

            $table->enum('category', [
                'Welder',
                'Fitter',
                'Helper',
                'Rigger',
                'Assistant Fitter',
                'Grinder',
                'Taker Welder',
                'Gas Cutter',
                'Khallasi Helper',
                'Visual Grinder',
                'Structure Fitter'
            ])->nullable();

            $table->string('phone', 10)->nullable();

            $table->string('address')->nullable();

            // Working
            $table->enum('working_days', [
                '26',
                '27',
                '28',
                '29',
                '30',
                '31'
            ])->default('26');

            $table->enum('working_hours_per_day', [
                '8',
                '9',
                '10',
                '11',
                '12',
                '13'
            ])->default('8');

            // Salary
            $table->decimal('total_salary', 10, 2)
                ->default(0)
                ->nullable();

            $table->decimal('daily_wage', 10, 2)
                ->default(0)
                ->nullable();

            $table->decimal('basic_salary', 10, 2)
                ->default(0)
                ->nullable();

            $table->decimal('hra', 10, 2)
                ->default(0)
                ->nullable();

            $table->decimal('other_allowance', 10, 2)
                ->default(0)
                ->nullable();

            // Overtime
            $table->decimal('overtime_hours', 5, 2)
                ->default(0)
                ->nullable()
                ->comment('Total overtime hours in a month');

            $table->enum('ot_rate_multiplier', [
                '1.5',
                '2.0'
            ])->default('1.5');

            $table->decimal('overtime_rate', 10, 2)
                ->default(0)
                ->nullable()
                ->comment('Per hour overtime rate');

            // PF
            $table->decimal('pf_percentage', 5, 2)
                ->default(12.00)
                ->nullable()
                ->comment('PF deduction percentage');

            // Joining
            $table->date('joining_date')->nullable();

            // Status
            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            // Bank Details
            $table->string('Account_Number')
                ->unique()
                ->nullable();

            $table->string('IFSC')
                ->nullable();

            // Personal Documents
            $table->string('Aadhar_Number')
                ->unique()
                ->nullable();

            $table->string('Pan_Card')
                ->unique()
                ->nullable();

            // PF / ESIC
            $table->string('UAN')
                ->unique()
                ->nullable();

            $table->string('ESIC_Number')
                ->unique()
                ->nullable();

            // $table->enum('relation')

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('labours');
    }
};