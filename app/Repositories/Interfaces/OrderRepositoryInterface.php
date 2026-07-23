<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Lấy danh sách đơn hàng của một user kèm theo items và product
     */
    public function getOrdersByUserId(int $userId, ?string $status = null): Collection;

    /**
     * Lấy danh sách đơn hàng của user đã được phân trang và lọc từ Backend
     */
    public function getPaginatedOrdersByUserId(int $userId, array $filters = [], int $perPage = 10): LengthAwarePaginator;

    /**
     * Tìm một đơn hàng cụ thể của user
     */
    public function findUserOrder(int $userId, int $orderId): ?Order;

    /**
     * Cập nhật trạng thái của đơn hàng
     */
    public function updateStatus(int $orderId, string $status): bool;

    /**
     * Tạo đơn hàng mới cùng với các items và trừ tồn kho sản phẩm
     */
    public function createOrderWithItems(array $orderData, array $cartItems): Order;

    public function getPaginatedOrdersAdmin(Request $request, int $perPage = 10);
}
