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
  public function up(): void
    {
        Schema::table('salary_slips', function (Blueprint $table) {

            $table->decimal('earned_basic', 10, 2)
                ->default(0)
                ->after('basic_salary');

            $table->decimal('earned_hra', 10, 2)
                ->default(0)
                ->after('earned_basic');

            $table->decimal('earned_other_allowance', 10, 2)
                ->default(0)
                ->after('earned_hra');

            $table->decimal('earned_salary', 10, 2)
                ->default(0)
                ->after('earned_other_allowance');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('salary_slips', function (Blueprint $table) {

            $table->dropColumn([
                'earned_basic',
                'earned_hra',
                'earned_other_allowance',
                'earned_salary'
            ]);

        });
    }
};
