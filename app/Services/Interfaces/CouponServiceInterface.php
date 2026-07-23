<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\BaseServiceInterface;
use App\Models\Coupon;

use Illuminate\Http\Request;

interface CouponServiceInterface extends BaseServiceInterface
{
    public function getFilteredCoupons(Request $request, int $perPage = 10);
    public function create(array $data);
    public function update(array $data, int $id);
    public function applyCoupon(string $code, float $totalPrice, ?int $userId): array;
    public function removeCoupon(): void;
    public function getAppliedCoupon(float $totalPrice): ?array;
    public function recordUsage(Coupon $coupon, int $userId, int $orderId): void;
    public function getValidCouponsForUser(?int $userId = null, int $perPage = 9);
}
