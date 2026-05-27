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
        Schema::create('staff_salary_slips', function (Blueprint $table) {

        $table->id();

        $table->foreignId('staff_id')->constrained()->onDelete('cascade');

        $table->integer('month');

        $table->integer('year');

        $table->integer('working_days')->nullable();

        $table->integer('paid_days')->nullable();

        $table->decimal('basic_salary', 10, 2)->default(0);

        $table->decimal('hra', 10, 2)->default(0);

        $table->decimal('other_allowance', 10, 2)->default(0);

        $table->decimal('gross_salary', 10, 2)->default(0);

        $table->decimal('pf_deduction', 10, 2)->default(0);

        $table->decimal('advance_deduction', 10, 2)->default(0);

        $table->decimal('other_deduction', 10, 2)->default(0);

        $table->decimal('total_deduction', 10, 2)->default(0);

        $table->decimal('net_salary', 10, 2)->default(0);

        $table->foreignId('site_id')->nullable()->constrained()->nullOnDelete();

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
        Schema::dropIfExists('staff_salary_slips');
    }
};
