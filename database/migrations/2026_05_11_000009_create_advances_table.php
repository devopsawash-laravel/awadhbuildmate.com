<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('labour_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('given_date');
            $table->string('remarks')->nullable();
            $table->boolean('is_deducted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Schema::dropIfExists('advances');
    }
};