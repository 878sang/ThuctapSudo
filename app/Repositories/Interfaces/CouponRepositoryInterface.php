<?php

namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;

interface CouponRepositoryInterface extends BaseRepositoryInterface
{
    public function getFilteredCoupons(Request $request, int $perPage = 10);
    public function findByCode(string $code);
    public function getUserUsageCount(int $couponId, int $userId): int;
    public function recordUsage(int $couponId, int $userId, int $orderId): void;
    public function getValidCouponsForUser(?int $userId = null, int $perPage = 9);
}
