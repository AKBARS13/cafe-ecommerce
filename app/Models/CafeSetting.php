<?php

namespace App\Models;

class CafeSetting extends BaseModel
{
    protected $fillable = [
        'open_time',
        'close_time',
        'weekend_open_time',
        'weekend_close_time',
        'accept_reservation',
        'reservation_start_time',
        'reservation_end_time',
        'max_reservation_days',
        'cafe_name',
        'cafe_description',
        'cafe_address',
        'cafe_phone',
        'cafe_email',
        'qris_image',
        'qris_merchant_name',
        'qris_instructions',
        'qris_enabled',
    ];

    protected $casts = [
        'accept_reservation' => 'boolean',
        'qris_enabled' => 'boolean',
    ];

    public function getDisplayName(): string
    {
        return $this->cafe_name;
    }

    public function isActive(): bool
    {
        return true;
    }

    public static function current(): self
    {
        $setting = self::first();

        if (!$setting) {
            $setting = self::create([
                'open_time' => '08:00:00',
                'close_time' => '22:00:00',
                'weekend_open_time' => '08:00:00',
                'weekend_close_time' => '23:00:00',
                'accept_reservation' => true,
                'reservation_start_time' => '00:00:00',
                'reservation_end_time' => '23:59:59',
                'max_reservation_days' => 7,
                'cafe_name' => 'Cafe Kopi Nusantara',
                'cafe_description' => 'Menyajikan kopi dan makanan terbaik dengan cita rasa nusantara.',
                'cafe_address' => 'Jl. Kopi No. 123, Jakarta',
                'cafe_phone' => '+62 812 3456 7890',
                'cafe_email' => 'info@cafekopinusantara.com',
                'qris_enabled' => false,
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

    public function getFormattedWeekendOpenTimeAttribute(): string
    {
        return $this->weekend_open_time ? date('H:i', strtotime($this->weekend_open_time)) : $this->formatted_open_time;
    }

    public function getFormattedWeekendCloseTimeAttribute(): string
    {
        return $this->weekend_close_time ? date('H:i', strtotime($this->weekend_close_time)) : $this->formatted_close_time;
    }
}