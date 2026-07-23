<?php

namespace App\Services;

use App\Services\Interfaces\CouponServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Models\Coupon;

use Illuminate\Http\Request;

/**
 * @property CouponRepositoryInterface $repository
 */
class CouponService extends BaseService implements CouponServiceInterface
{
    public function __construct(CouponRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getFilteredCoupons(Request $request, int $perPage = 10)
    {
        return $this->repository->getFilteredCoupons($request, $perPage);
    }

    public function create(array $data, Request $request)
    {
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;
        return $this->repository->create($data);
    }

    public function update(array $data, Request $request, int $id)
    {
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : false;
        return $this->repository->update($data, $id);
    }

    public function applyCoupon(string $code, float $totalPrice, ?int $userId): array
    {
        $coupon = $this->repository->findByCode($code);
        if (!$coupon) {
            throw new \Exception('Mã giảm giá không tồn tại');
        }

        // Kiểm tra điều kiện sử dụng
        if (!$coupon->is_active) {
            throw new \Exception('Mã giảm giá đã bị khóa hoặc ngừng hoạt động');
        }
        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            throw new \Exception('Mã giảm giá đã hết lượt sử dụng');
        }
        if ($coupon->start_date && $coupon->start_date > now()) {
            throw new \Exception('Mã giảm giá chưa đến thời gian áp dụng');
        }
        if ($coupon->end_date && $coupon->end_date < now()) {
            throw new \Exception('Mã giảm giá đã hết hạn sử dụng');
        }
        if ($totalPrice < $coupon->min_order_amount) {
            throw new \Exception('Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($coupon->min_order_amount, 0, ',', '.') . ' đ');
        }
        if ($userId && $coupon->user_limit !== null) {
            $userUsage = $this->repository->getUserUsageCount($coupon->id, $userId);
            if ($userUsage >= $coupon->user_limit) {
                throw new \Exception('Bạn đã dùng hết số lượt áp dụng cho mã giảm giá này');
            }
        }

        $discountAmount = $this->calculateDiscount($coupon, $totalPrice);
        $newTotal = max(0, $totalPrice - $discountAmount);

        session(['applied_coupon' => [
            'code' => $coupon->code,
            'coupon_id' => $coupon->id,
            'discount_amount' => $discountAmount,
            'new_total' => $newTotal
        ]]);

        return [
            'success' => true,
            'coupon' => $coupon,
            'discount_amount' => $discountAmount,
            'new_total' => $newTotal
        ];
    }

    public function removeCoupon(): void
    {
        session()->forget('applied_coupon');
    }

    private function calculateDiscount($coupon, $totalPrice): float
    {
        if ($coupon->type === 'percent') {
            $discount = ($totalPrice * $coupon->value) / 100;
            if ($coupon->max_discount_amount && $discount > $coupon->max_discount_amount) {
                $discount = $coupon->max_discount_amount;
            }
            return min($discount, $totalPrice);
        }
        return min($coupon->value, $totalPrice);
    }

    public function getAppliedCoupon(float $totalPrice): ?array
    {
        $appliedCoupon = session('applied_coupon');

        if (!$appliedCoupon) {
            return null;
        }
        try {
            $coupon = $this->repository->find($appliedCoupon['coupon_id']);

            if (!$coupon) {
                session()->forget('applied_coupon');
                return null;
            }
            if (!$coupon->is_active || ($coupon->end_date && $coupon->end_date < now())) {
                session()->forget('applied_coupon');
                return null;
            }

            if ($totalPrice < $coupon->min_order_amount) {
                return [
                    'code' => $coupon->code,
                    'message' => 'Đơn hàng chưa đủ điều kiện áp dụng mã giảm giá này.'
                ];
            }

            $discountAmount = $this->calculateDiscount($coupon, $totalPrice);
            $newTotal = max(0, $totalPrice - $discountAmount);

            $appliedCoupon['discount_amount'] = $discountAmount;
            $appliedCoupon['new_total'] = $newTotal;

            session(['applied_coupon' => $appliedCoupon]);

            return $appliedCoupon;
        } catch (\Exception $e) {
            session()->forget('applied_coupon');
            return null;
        }
    }

    public function recordUsage(Coupon $coupon, int $userId, int $orderId): void
    {
        $this->repository->recordUsage($coupon->id, $userId, $orderId);
    }

    public function getValidCouponsForUser(?int $userId = null, int $perPage = 9)
    {
        return $this->repository->getValidCouponsForUser($userId, $perPage);
    }
}
