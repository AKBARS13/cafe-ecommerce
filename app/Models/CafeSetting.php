<?php

namespace App\Models;

class CafeSetting extends BaseModel
{
    protected $fillable = [
        'open_time',
        'close_time',
        'accept_reservation',
        'reservation_start_time',
        'reservation_end_time',
        'max_reservation_days',
        'cafe_name',
        'cafe_address',
        'cafe_phone',
    ];

    protected $casts = [
        'accept_reservation' => 'boolean',
    ];

    public function getDisplayName(): string
    {
        return $this->cafe_name;
    }

    public function isActive(): bool
    {
        return true;
    }

    /**
     * Get the singleton instance of cafe settings
     */
    public static function current(): self
    {
        $setting = self::first();
        
        if (!$setting) {
            $setting = self::create([
                'open_time' => '08:00:00',
                'close_time' => '22:00:00',
                'accept_reservation' => true,
                'reservation_start_time' => '00:00:00',
                'reservation_end_time' => '23:59:59',
                'max_reservation_days' => 7,
                'cafe_name' => 'Cafe Kopi Nusantara',
            ]);
        }

        return $setting;
    }

    public function getFormattedOpenTimeAttribute(): string
    {
        return date('H:i', strtotime($this->open_time));
    }

    public function getFormattedCloseTimeAttribute(): string
    {
        return date('H:i', strtotime($this->close_time));
    }
}