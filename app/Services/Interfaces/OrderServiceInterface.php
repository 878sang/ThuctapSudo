<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Http\Request;

interface OrderServiceInterface extends BaseServiceInterface
{
    public function cancelOrder(int $userId, int $orderId): bool;

    /**
     * Tính toán các số liệu thống kê tổng quan của user.
     */
    public function getOverviewStats(int $userId): array;

    /**
     * Lấy danh sách đơn hàng của user (tuỳ chọn lọc theo status).
     */
    public function getOrdersByUser(int $userId, ?string $status = null);

    /**
     * Lấy danh sách đơn hàng của user đã phân trang và lọc từ Backend.
     */
    public function getPaginatedOrdersByUser(int $userId, array $filters = [], int $perPage = 10);

    public function getPaginatedOrdersAdmin(Request $request, int $perPage = 10);

    public function updateOrderStatus(int $orderId, string $status, ?string $note = null): bool;
}
