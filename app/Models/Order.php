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

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
