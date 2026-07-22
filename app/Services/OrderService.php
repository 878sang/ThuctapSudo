<?php

namespace App\Services;

use App\Services\Interfaces\OrderServiceInterface;
use App\Services\Interfaces\CartServiceInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\Interfaces\UserAddressServiceInterface;
use Carbon\Carbon;
use Override;

/**
 * @property OrderRepositoryInterface $repository
 */
class OrderService extends BaseService implements OrderServiceInterface
{
    protected CartServiceInterface $cartService;
    protected UserAddressServiceInterface $userAddressService;

    public function __construct(OrderRepositoryInterface $repository, CartServiceInterface $cartService, UserAddressServiceInterface $userAddressService)
    {
        parent::__construct($repository);
        $this->cartService = $cartService;
        $this->userAddressService = $userAddressService;
    }
    #[Override]
    public function create(array $data, Request $request)
    {
        return DB::transaction(function () use ($data) {
            $cartItems = $this->cartService->getCart();
            if (empty($cartItems)) {
                throw new \Exception('Giỏ hàng của bạn đang trống!');
            }

            if ($data['address_method'] === 'account') {
                $user = Auth::user();
                if (!$user) {
                    throw new \Exception('Vui lòng đăng nhập để sử dụng địa chỉ từ tài khoản.');
                }

                $address = $this->userAddressService->getDefaultAddressForUser(Auth::id());
                $customerName = $address->name;
                $customerPhone = $address->phone;
                $customerAddress = implode(', ', array_filter([
                    $address->address_detail,
                    $address->ward,
                    $address->district,
                    $address->city_province
                ]));
            } else {
                $customerName = $data['customer_name'];
                $customerPhone = $data['customer_phone'];
                $customerAddress = implode(', ', array_filter([
                    $data['street'] ?? null,
                    $data['ward'] ?? null,
                    $data['district'] ?? null,
                    $data['province'] ?? null
                ]));
            }

            $dataOrder = [
                'user_id' => Auth::id(),
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'customer_address' => $customerAddress,
                'total_price' => $this->cartService->getTotalPrice(),
                'shipping_fee' => 0,
                'payment_method' => $data['payment_method'] ?? 'cod',
                'status' => 'pending',
                'is_vat' => $data['is_vat'] ?? 0,
                'company_name' => $data['company_name'] ?? null,
                'company_email' => $data['company_email'] ?? null,
                'tax_code' => $data['tax_code'] ?? null,
                'company_address' => $data['company_address'] ?? null,
            ];

            $order = $this->repository->createOrderWithItems($dataOrder, $cartItems);
            $this->cartService->clear();
            return $order;
        });
    }

    public function cancelOrder(int $userId, int $orderId): bool
    {
        $order = $this->repository->findUserOrder($userId, $orderId);

        if (!$order) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Không tìm thấy đơn hàng của bạn.');
        }

        if ($order->status !== 'pending') {
            throw new \Exception('Chỉ có thể hủy đơn hàng đang chờ xử lý.');
        }

        return $this->repository->updateStatus($orderId, 'cancelled');
    }

    /**
     * Lấy danh sách đơn hàng của user.
     */
    public function getOrdersByUser(int $userId, ?string $status = null)
    {
        return $this->repository->getOrdersByUserId($userId, $status);
    }

    /**
     * Lấy danh sách đơn hàng đã phân trang và lọc từ Backend.
     */
    public function getPaginatedOrdersByUser(int $userId, array $filters = [], int $perPage = 10)
    {
        return $this->repository->getPaginatedOrdersByUserId($userId, $filters, $perPage);
    }

    /**
     * Tính toán các số liệu thống kê tổng quan cho trang dashboard.
     */
    public function getOverviewStats(int $userId): array
    {
        $now       = Carbon::now();
        $allOrders = $this->repository->getOrdersByUserId($userId);

        $delivered = $allOrders->where('status', 'delivered');

        return [
            'totalRevenue'   => $delivered->sum('total_price'),
            'monthRevenue'   => $delivered
                ->filter(fn ($o) => Carbon::parse($o->created_at)->isSameMonth($now))
                ->sum('total_price'),
            'totalDelivered' => $delivered->count(),
            'monthDelivered' => $delivered
                ->filter(fn ($o) => Carbon::parse($o->created_at)->isSameMonth($now))
                ->count(),
            'totalOrders'    => $allOrders->count(),
            'monthOrders'    => $allOrders
                ->filter(fn ($o) => Carbon::parse($o->created_at)->isSameMonth($now))
                ->count(),
        ];
    }
}
