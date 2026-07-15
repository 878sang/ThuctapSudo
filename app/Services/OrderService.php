<?php

namespace App\Services;

use App\Services\Interfaces\OrderServiceInterface;
use App\Services\Interfaces\CartServiceInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Override;

/**
 * @property OrderRepositoryInterface $repository
 */
class OrderService extends BaseService implements OrderServiceInterface
{
    protected CartServiceInterface $cartService;

    public function __construct(OrderRepositoryInterface $repository, CartServiceInterface $cartService)
    {
        parent::__construct($repository);
        $this->cartService = $cartService;
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

                if (empty($user->phone) || empty($user->address)) {
                    throw new \Exception('Tài khoản của bạn chưa cập nhật đầy đủ số điện thoại hoặc địa chỉ nhận hàng.');
                }

                $customerName = $user->name;
                $customerPhone = $user->phone;
                $customerAddress = $user->address;
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

            $order = $this->repository->create($dataOrder);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                $item['product']->decrement('stock', $item['quantity']);
            }
            $this->cartService->clear();
            return $order;
        });
    }
}
