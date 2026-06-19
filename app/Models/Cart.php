<?php

namespace App\Models;

class Cart extends BaseModel
{
    protected $fillable = [
        'user_id',
        'total_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function getDisplayName(): string
    {
        return 'Keranjang #' . $this->id;
    }

    public function isActive(): bool
    {
        return $this->items()->count() > 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function recalculateTotal(): void
    {
        $this->total_amount = $this->items->sum('subtotal');
        $this->save();
    }
}