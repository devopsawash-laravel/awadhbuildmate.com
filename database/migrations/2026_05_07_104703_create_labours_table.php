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
            $table->string('name');
            $table->string('employee_id')->unique();
            $table->enum('category', ['Welder', 'Fitter', 'Helper', 'Rigger']);
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->decimal('daily_wage', 10, 2)->default(0);
            $table->decimal('overtime_rate', 10, 2)->default(0)->comment('Per hour overtime rate');
            $table->decimal('pf_percentage', 5, 2)->default(12.00)->comment('PF deduction percentage');
            $table->date('joining_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            // $table->string('Account Number')->unique()->default('1234567890');
            // $table->string('Aadhar Number')->unique()->default('1234567890');
            // $table->string('Pan Card')->unique()->default('PAN1234567890');
            // $table->string('IFSC')->unique()->default('IFSC1234567890');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('labours');
    }
};