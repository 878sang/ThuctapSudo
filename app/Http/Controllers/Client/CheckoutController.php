<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\OrderServiceInterface;
use App\Http\Requests\StoreOrderRequest;

class CheckoutController extends Controller
{
    protected OrderServiceInterface $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }
    public function validateCheckout(StoreOrderRequest $request)
    {
        return response()->json([
            'success' => true
        ]);
    }
    public function placeOrder(StoreOrderRequest $request)
    {
        $data = $request->validated();
        try {
            $order = $this->orderService->create($data, $request);

            return redirect()->route('checkout.success')->with('success_order_id', $order->id);
        } catch (\Exception $e) {
            return back()->with('error', 'Đặt hàng không thành công: ' . $e->getMessage())->withInput();
        }
    }

    public function success()
    {
        $orderId = session('success_order_id');
        if (!$orderId) {
            return redirect()->route('products.showClient');
        }
        $order = $this->orderService->findOrFail($orderId);
        return view('client.cart.success', compact('order'));
    }
}
