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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // e.g. Dahej
            $table->string('slug')->unique();                // e.g. dahej
            $table->string('location');                      // full address
            $table->string('state')->nullable();             // Gujarat
            $table->string('client')->nullable();            // HPCL
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->date('start_date')->nullable();
            $table->date('expected_end_date')->nullable();
            $table->text('description')->nullable();
            $table->string('site_incharge')->nullable();     // person in charge
            $table->string('incharge_phone')->nullable();
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
        // Schema::dropIfExists('sites');
    }
};
