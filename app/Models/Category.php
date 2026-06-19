<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getDisplayName(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getActiveProductCountAttribute(): int
    {
        return $this->products()->where('is_available', true)->count();
    }
}