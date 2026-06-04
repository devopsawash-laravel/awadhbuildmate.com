<?php

// ══════════════════════════════════════════════════════
//  database/migrations/xxxx_create_invoices_table.php
//  Run: php artisan make:migration create_invoices_table
//  Then replace the up() and down() with this content.
// ══════════════════════════════════════════════════════

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // Bill Info
            $table->string('bill_no');
            $table->date('bill_date');

            // Billed To
            $table->string('to_name');
            $table->string('to_co')->nullable();

            // From
            $table->string('from_name')->default('Awadh Buildmate');
            $table->text('from_address')->nullable();
            $table->string('from_pan', 20)->nullable();
            $table->string('from_gst', 20)->nullable();

            // Contact
            $table->string('contact_person')->nullable();
            $table->string('contact_number', 20)->nullable();

            // Bank
            $table->string('bank_name')->nullable();
            $table->string('account_no', 30)->nullable();
            $table->string('ifsc_code', 15)->nullable();
            $table->string('proprietor')->nullable();

            // Tax & Deductions
            $table->decimal('gst_rate', 5, 2)->default(18);
            $table->decimal('tds_rate', 5, 2)->default(5);
            $table->decimal('deposit', 12, 2)->default(0);

            // Note
            $table->text('note')->nullable();

            // Computed totals (stored for records/reports)
            $table->decimal('total_amount',    14, 2)->default(0);
            $table->decimal('gst_amount',      14, 2)->default(0);
            $table->decimal('bill_amount',     14, 2)->default(0);
            $table->decimal('tds_amount',      14, 2)->default(0);
            $table->decimal('total_deduction', 14, 2)->default(0);
            $table->decimal('grand_total',     14, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};


// ══════════════════════════════════════════════════════
//  database/migrations/xxxx_create_invoice_items_table.php
//  Run: php artisan make:migration create_invoice_items_table
// ══════════════════════════════════════════════════════

// return new class extends Migration
// {
//     public function up(): void
//     {
//         Schema::create('invoice_items', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('invoice_id')
//                   ->constrained()
//                   ->cascadeOnDelete();
//             $table->text('particulars');
//             $table->decimal('qty',    10, 2)->default(0);
//             $table->decimal('rate',   12, 2)->default(0);
//             $table->decimal('amount', 14, 2)->default(0);
//             $table->timestamps();
//         });
//     }
//
//     public function down(): void
//     {
//         Schema::dropIfExists('invoice_items');
//     }
// };