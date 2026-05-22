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
        Schema::table('salary_slips', function (Blueprint $table) {
            $table->decimal('loan_deduction', 10, 2)
                ->default(0);

            $table->decimal('fine_deduction', 10, 2)
                ->default(0);

            $table->decimal('damage_loss_deduction', 10, 2)
                ->default(0);

            $table->decimal('arrears', 10, 2)
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_slips', function (Blueprint $table) {
            //
        });
    }
};
