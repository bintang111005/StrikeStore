<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'order_id', 'user_id', 'transaction_code', 'amount', 'payment_method',
    'status', 'payment_proof', 'payment_details', 'paid_at', 'expired_at',
])]
class Transaction extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'expired_at' => 'datetime',
        ];
    }

    /**
     * Get the order for this transaction.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user for this transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the transaction is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
