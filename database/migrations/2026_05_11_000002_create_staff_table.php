<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('employee_id')->unique()->nullable();
            $table->enum('category', ['Site Incharge','QC-Quality','Safety Supervisor','Planning','Execution','Admin','Supervisor'])->nullable();
            $table->string('phone')->nullable();
            $table->enum('working_days', ['26','27','28','29','30','31'])->default('26');
            $table->decimal('total_salary', 10, 2)->default(0)->nullable();
            $table->string('address')->nullable();
            $table->decimal('daily_wage', 10, 2)->default(0)->nullable();
            $table->decimal('basic_salary', 10, 2)->default(0)->nullable();
            $table->decimal('hra', 10, 2)->default(0)->nullable();
            $table->decimal('other_allowance', 10, 2)->default(0)->nullable();
            $table->decimal('pf_percentage', 5, 2)->default(12.00)->comment('PF deduction percentage')->nullable();
            $table->date('joining_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('Account_Number')->unique()->nullable();
            $table->string('Aadhar_Number')->unique()->nullable();
            $table->string('Pan_Card')->unique()->nullable();
            $table->string('IFSC')->nullable();
            $table->string('UAN')->unique()->nullable();
            $table->string('ESIC_Number')->unique()->nullable();
            $table->string('relation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
};
