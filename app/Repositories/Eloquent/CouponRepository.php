<?php

namespace App\Repositories\Eloquent;

use App\Models\Coupon;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;


use Illuminate\Http\Request;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    public function __construct(Coupon $coupon)
    {
        $this->model = $coupon;
    }

    public function getFilteredCoupons(Request $request, int $perPage = 10)
    {
        $query = $this->model->newQuery();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function findByCode(string $code)
    {
        return $this->model->where('code', $code)->first();
    }

    public function getUserUsageCount(int $couponId, int $userId): int
    {
        $coupon = $this->find($couponId);
        if (!$coupon) return 0;
        return $coupon->users()
            ->where('user_id', $userId)
            ->whereHas('orders', function ($query) {
                $query->where('status', '!=', 'cancelled');
            })
            ->count();
    }

    public function recordUsage(int $couponId, int $userId, int $orderId): void
    {
        $coupon = $this->model->find($couponId);
        if ($coupon) {
            $coupon->increment('used_count');
            $coupon->users()->attach($userId, [
                'order_id' => $orderId,
            ]);
        }
    }

    public function getValidCouponsForUser(?int $userId = null, int $perPage = 9)
    {
        $now = now();

        return $this->model->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereColumn('used_count', '<', 'usage_limit');
            })
            ->when($userId, function ($query, $userId) {
                $query->where(function ($q) use ($userId) {
                    $q->whereNull('user_limit')
                        ->orWhere('user_limit', '>', function ($subQuery) use ($userId) {
                            $subQuery->selectRaw('count(*)')
                                ->from('coupon_user')
                                ->whereColumn('coupon_user.coupon_id', 'coupons.id')
                                ->where('coupon_user.user_id', $userId)
                                ->whereNotNull('coupon_user.order_id');
                        });
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
