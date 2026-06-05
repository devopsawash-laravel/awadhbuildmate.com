<?php

// ══════════════════════════════════════════════════════
//  app/Models/Invoice.php
// ══════════════════════════════════════════════════════

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        // Bill Info
        'bill_no',
        'bill_date',

        // Billed To
        'to_name',
        'to_co',

        // From (Your Details)
        'from_name',
        'from_address',
        'from_pan',
        'from_gst',

        // Contact
        'contact_person',
        'contact_number',

        // Bank
        'bank_name',
        'account_no',
        'ifsc_code',
        'proprietor',

        // Tax & Deductions
        'gst_rate',
        'tds_rate',
        'deposit',

        // Note
        'note',

        // Computed totals (stored for records)
        'total_amount',
        'gst_amount',
        'bill_amount',
        'tds_amount',
        'total_deduction',
        'grand_total',

        'received_amount',
        'payment_status',
    ];
    protected $casts = [
        'bill_date'       => 'date',
        'gst_rate'        => 'decimal:2',
        'tds_rate'        => 'decimal:2',
        'deposit'         => 'decimal:2',
        'total_amount'    => 'decimal:2',
        'gst_amount'      => 'decimal:2',
        'bill_amount'     => 'decimal:2',
        'tds_amount'      => 'decimal:2',
        'total_deduction' => 'decimal:2',
        'grand_total'     => 'decimal:2',
    ];

    // ── Relationships ────────────────────────────────
    public function items()
    {
        return $this->hasMany(InvoiceItems::class);
    }

    // ── Computed totals accessor ─────────────────────
    public function getComputedTotalsAttribute(): array
    {
        $total      = $this->items->sum('amount');
        $gst        = round($total * ($this->gst_rate / 100));
        $billAmount = $total + $gst;
        $tds        = round($total * ($this->tds_rate / 100));
        $totalDed   = $this->deposit + $tds;
        $grand      = $billAmount - $totalDed;

        return compact('total', 'gst', 'billAmount', 'tds', 'totalDed', 'grand');
    }
    public function getPendingAmountAttribute()
    {
        return max(0, $this->grand_total - $this->received_amount);
    }
}