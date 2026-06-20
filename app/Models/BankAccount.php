<?php

namespace App\Models;

class BankAccount extends BaseModel
{
    protected $fillable = [
        'bank_name',
        'account_number',
        'account_holder',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getDisplayName(): string
    {
        return $this->bank_name . ' - ' . $this->account_number;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}