<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    /**
     * Lấy danh sách đơn hàng của một user kèm theo items và product
     */
    public function getOrdersByUserId(int $userId, ?string $status = null): Collection
    {
        $query = $this->model->newQuery()
            ->where('user_id', $userId)
            ->with(['items.product'])
            ->latest();

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    /**
     * Lấy danh sách đơn hàng của user đã được phân trang và lọc từ Backend
     */
    public function getPaginatedOrdersByUserId(int $userId, array $filters = [], int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->where('user_id', $userId)
            ->with(['items.product'])
            ->latest();

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhereHas('items.product', function ($pq) use ($search) {
                        $pq->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Tìm một đơn hàng cụ thể của user
     */
    public function findUserOrder(int $userId, int $orderId): ?Order
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->where('id', $orderId)
            ->first();
    }

    /**
     * Cập nhật trạng thái của đơn hàng
     */
    public function updateStatus(int $orderId, string $status): bool
    {
        $order = $this->model->find($orderId);
        if ($order) {
            return $order->update(['status' => $status]);
        }
        return false;
    }

    /**
     * Tạo đơn hàng mới cùng với các items và trừ tồn kho sản phẩm
     */
    public function createOrderWithItems(array $orderData, array $cartItems): Order
    {
        return DB::transaction(function () use ($orderData, $cartItems) {
            $order = $this->model->create($orderData);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Trừ tồn kho
                $item['product']->decrement('stock', $item['quantity']);
            }

            return $order;
        });
    }
    public function getPaginatedOrdersAdmin(Request $request, int $perPage = 10)
    {
        $query = $this->model->query()
            ->with(['items.product', 'user'])
            ->latest();

        if (!empty($request->status) && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if (!empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if (!empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if (!empty($request->search)) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhereHas('items.product', function ($pq) use ($search) {
                        $pq->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }
}
