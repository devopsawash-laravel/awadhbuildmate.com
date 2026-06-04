<?php

// ══════════════════════════════════════════════════════
//  app/Models/InvoiceItem.php
// ══════════════════════════════════════════════════════

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'particulars',
        'qty',
        'rate',
        'amount',
    ];

    protected $casts = [
        'qty'    => 'decimal:2',
        'rate'   => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    // ── Relationships ────────────────────────────────
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // ── Auto-calculate amount before saving ──────────
    protected static function booted()
    {
        static::saving(function (InvoiceItem $item) {
            if ($item->qty && $item->rate) {
                $item->amount = round($item->qty * $item->rate, 2);
            }
        });
    }
}