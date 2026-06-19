<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class BaseModel extends Model
{
    use HasFactory;

    public function getFormattedPrice(string $column = 'price'): string
    {
        return 'Rp ' . number_format($this->{$column}, 0, ',', '.');
    }

    public function getFormattedDate(): string
    {
        return $this->created_at->format('d M Y, H:i');
    }

    abstract public function getDisplayName(): string;

    abstract public function isActive(): bool;
}