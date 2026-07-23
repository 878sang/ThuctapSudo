<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'max_discount_amount',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'user_limit',
        'start_date',
        'end_date',
        'is_active',
    ];
    protected $casts = [
        'value' => 'float',
        'max_discount_amount' => 'float',
        'min_order_amount' => 'float',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];
    public function calculateDiscount(float $orderTotal): float
    {
        if ($this->type === 'percent') {
            $discount = ($orderTotal * $this->value) / 100;
            if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
                $discount = $this->max_discount_amount;
            }
            return min($discount, $orderTotal);
        }
        return min($this->value, $orderTotal);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user')->withPivot('order_id')->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
