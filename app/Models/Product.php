<?php

namespace App\Models;

class Product extends BaseModel
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'image',
        'stock',
        'is_available',
        'is_featured',
        'type',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function getDisplayName(): string
    {
        return $this->name . ' - ' . $this->getFormattedPrice();
    }

    public function isActive(): bool
    {
        return $this->is_available && $this->stock > 0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFinalPriceAttribute(): float
    {
        if ($this->discount_price && $this->discount_price > 0) {
            return (float) $this->discount_price;
        }
        return (float) $this->price;
    }

    public function getFormattedFinalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }

    public function getDiscountPercentageAttribute(): int
    {
        if ($this->discount_price && $this->discount_price > 0 && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_price && $this->discount_price > 0 && $this->discount_price < $this->price;
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stock', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function decreaseStock(int $quantity): bool
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            return $this->save();
        }
        return false;
    }
}