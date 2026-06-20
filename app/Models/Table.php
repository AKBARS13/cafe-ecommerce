<?php

namespace App\Models;

class Table extends BaseModel
{
    protected $fillable = [
        'table_number',
        'capacity',
        'status',
        'location',
        'notes',
    ];

    public function getDisplayName(): string
    {
        return 'Meja ' . $this->table_number;
    }

    public function isActive(): bool
    {
        return $this->status !== 'maintenance';
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'reserved' => 'Dipesan',
            'maintenance' => 'Maintenance',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        $colors = [
            'available' => 'green',
            'occupied' => 'red',
            'reserved' => 'yellow',
            'maintenance' => 'gray',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getLocationLabelAttribute(): string
    {
        return $this->location === 'indoor' ? 'Indoor' : 'Outdoor';
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}