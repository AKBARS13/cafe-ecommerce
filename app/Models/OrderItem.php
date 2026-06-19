<?php

namespace App\Models;

class OrderItem extends BaseModel
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
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
        return $this->product_name . ' x' . $this->quantity;
    }

    public function isActive(): bool
    {
        return true;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}