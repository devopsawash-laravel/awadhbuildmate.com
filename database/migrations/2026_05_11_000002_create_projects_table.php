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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('project_code')->nullable();
            $table->enum('type', ['Fabrication', 'Erection', 'Civil', 'Structural', 'Maintenance', 'Other']);
            $table->enum('status', ['planning', 'ongoing', 'on_hold', 'completed'])->default('ongoing');
            $table->date('start_date')->nullable();
            $table->date('expected_end_date')->nullable();
            $table->decimal('contract_value', 15, 2)->nullable();
            $table->integer('progress_percent')->default(0);    // 0–100
            $table->text('description')->nullable();
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
        // Schema::dropIfExists('projects');
    }
};
