<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\OrderServiceInterface;
use App\Http\Requests\UpdateOrderStatusRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderServiceInterface $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->getPaginatedOrdersAdmin($request, 10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = $this->orderService->with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, int $id)
    {
        $this->orderService->updateOrderStatus($id, $request->status);

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
