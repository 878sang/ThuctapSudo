<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'total_price',
        'coupon_code',
        'discount_amount',
        'shipping_fee',
        'status',
        'payment_method',
        'is_vat',
        'company_name',
        'company_email',
        'tax_code',
        'company_address'
    ];

    protected $appends = [
        'code',
        'thumbnail',
        'items_count',
        'cancel_url',
        'step_index',
        'status_label',
        'subtotal',
    ];

    public function getCodeAttribute(): string
    {
        return '#' . str_pad($this->id, 8, '0', STR_PAD_LEFT);
    }

    public function getThumbnailAttribute(): ?string
    {
        return $this->items->first()?->product?->thumbnail_url;
    }

    public function getItemsCountAttribute(): int
    {
        return $this->items->count();
    }

    public function getCancelUrlAttribute(): string
    {
        return route('profile.orders.cancel', $this->id);
    }

    public function getStepIndexAttribute(): int
    {
        return match ($this->status) {
            'pending'    => 1,
            'processing' => 2,
            'shipped'    => 3,
            'delivered'  => 4,
            'paid'       => 5,
            'completed'  => 6,
            'cancelled'  => 0,
            default      => 1,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Tạo đơn hàng',
            'processing' => 'Đóng gói',
            'shipped'    => 'Vận chuyển',
            'delivered'  => 'Giao hàng',
            'paid'       => 'Thanh toán',
            'completed'  => 'Hoàn tất',
            'cancelled'  => 'Đã hủy',
            default      => 'Tạo đơn hàng',
        };
    }

    public function getSubtotalAttribute(): float
    {
        if ($this->relationLoaded('items') && $this->items->count() > 0) {
            $sum = (float) $this->items->sum(function ($item) {
                $price = $item->price ?? $item->unit_price ?? 0;
                $qty = $item->quantity ?? 1;
                return $price * $qty;
            });
            if ($sum > 0) {
                return $sum;
            }
        }

        return (float) ($this->attributes['total_price'] ?? 0);
    }

    public static function getStepsList(): array
    {
        return [
            1 => 'Tạo đơn hàng',
            2 => 'Đóng gói',
            3 => 'Vận chuyển',
            4 => 'Giao hàng',
            5 => 'Thanh toán',
            6 => 'Hoàn tất',
        ];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
