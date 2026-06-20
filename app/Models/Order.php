<?php

namespace App\Models;

class Order extends BaseModel
{
    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'tax',
        'discount',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'order_type',
        'table_number',
        'reservation_date',
        'reservation_time',
        'guest_count',
        'table_id',
        'notes',
        'customer_name',
        'customer_phone',
        'paid_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'reservation_date' => 'date',
    ];

    public function getDisplayName(): string
    {
        return 'Order ' . $this->order_number;
    }

    public function isActive(): bool
    {
        return !in_array($this->status, ['completed', 'cancelled']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'ready' => 'Siap',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'processing' => 'indigo',
            'ready' => 'green',
            'completed' => 'gray',
            'cancelled' => 'red',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        $labels = [
            'unpaid' => 'Belum Bayar',
            'paid' => 'Sudah Bayar',
            'refunded' => 'Dikembalikan',
        ];

        return $labels[$this->payment_status] ?? $this->payment_status;
    }

    public function getOrderTypeLabelAttribute(): string
    {
        $labels = [
            'dine_in' => 'Makan di Tempat',
            'takeaway' => 'Takeaway',
            'reservation' => 'Reservasi',
        ];

        return $labels[$this->order_type] ?? $this->order_type;
    }

    public function getFormattedReservationAttribute(): string
    {
        if (!$this->reservation_date || !$this->reservation_time) {
            return '-';
        }

        return $this->reservation_date->format('d M Y') . ' jam ' . date('H:i', strtotime($this->reservation_time));
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'CF';
        $date = now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', today())->latest()->first();
        $sequence = $lastOrder ? intval(substr($lastOrder->order_number, -4)) + 1 : 1;

        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}