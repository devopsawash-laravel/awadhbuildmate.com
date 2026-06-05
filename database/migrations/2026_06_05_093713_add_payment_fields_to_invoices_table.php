<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('received_amount', 15, 2)->default(0)->after('grand_total');
            $table->enum('payment_status', [
                'Pending',
                'Partial',
                'Received'
            ])->default('Pending')->after('received_amount');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'received_amount',
                'payment_status'
            ]);
        });
    }
};