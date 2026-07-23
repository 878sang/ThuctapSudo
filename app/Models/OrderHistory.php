<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    // Không sử dụng cột updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'order_id',
        'user_id',
        'from_status',
        'to_status',
        'note'
    ];
    protected $appends = [
        'from_status_label',
        'to_status_label',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getFromStatusLabelAttribute(): ?string
    {
        return $this->from_status ? $this->getStatusLabel($this->from_status) : null;
    }
    public function getToStatusLabelAttribute(): ?string
    {
        return $this->to_status ? $this->getStatusLabel($this->to_status) : null;
    }
    private function getStatusLabel(string $status): string
    {
        return match ($status) {
            'pending'    => 'Tạo đơn hàng',
            'processing' => 'Đóng gói',
            'shipped'    => 'Vận chuyển',
            'delivered'  => 'Giao hàng',
            'paid'       => 'Thanh toán',
            'completed'  => 'Hoàn tất',
            'cancelled'  => 'Đã hủy',
            default      => $status,
        };
    }
}
