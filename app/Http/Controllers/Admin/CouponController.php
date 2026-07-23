<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CouponServiceInterface;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected CouponServiceInterface $couponService;

    public function __construct(CouponServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $coupons = $this->couponService->getFilteredCoupons($request, 10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(StoreCouponRequest $request)
    {
        $data = $request->validated();
        $this->couponService->create($data);
        return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã giảm giá thành công.');
    }

    public function edit(int $id)
    {
        $coupon = $this->couponService->findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(UpdateCouponRequest $request, int $id)
    {
        $data = $request->validated();
        $this->couponService->update($data, $id);
        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công.');
    }

    public function destroy(int $id)
    {
        $this->couponService->delete($id);
        return redirect()->route('admin.coupons.index')->with('success', 'Xóa mã giảm giá thành công.');
    }
}
