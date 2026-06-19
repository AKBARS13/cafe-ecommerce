<?php

namespace App\Models;

class CartItem extends BaseModel
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function getDisplayName(): string
    {
        return $this->product->name . ' x' . $this->quantity;
    }

    public function isActive(): bool
    {
        return $this->quantity > 0;
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}