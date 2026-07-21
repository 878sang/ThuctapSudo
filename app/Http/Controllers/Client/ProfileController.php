<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserAddressRequest;
use App\Http\Requests\UpdateUserAddressRequest;
use App\Services\Interfaces\UserAddressServiceInterface;
use App\Services\Interfaces\OrderServiceInterface;

class ProfileController extends Controller
{
    protected UserAddressServiceInterface $userAddressService;
    protected OrderServiceInterface $orderService;

    public function __construct(
        UserAddressServiceInterface $userAddressService,
        OrderServiceInterface $orderService
    ) {
        $this->userAddressService = $userAddressService;
        $this->orderService = $orderService;
    }

    /**
     * Display the user's profile dashboard.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $addresses = $this->userAddressService->getAddressesForUser($user->id);
        return view('client.profile.addresses', compact('user', 'addresses'));
    }

    /**
     * Cancel a pending order.
     */
    public function cancelOrder(Request $request, int $id)
    {
        try {
            $this->orderService->cancelOrder(Auth::id(), $id);
            return redirect()->back()->with('success', 'Đơn hàng của bạn đã được hủy thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function addresses()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $addresses = $this->userAddressService->getAddressesForUser($user->id);

        return view('client.profile.addresses', compact('user', 'addresses'));
    }
    public function storeAddress(StoreUserAddressRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->userAddressService->storeAddressForUser($user->id, $request->validated() + [
            'is_default' => $request->has('is_default')
        ]);

        return redirect()->back()->with('success', 'Thêm địa chỉ nhận hàng mới thành công.');
    }

    /**
     * Update an existing shipping address.
     */
    public function updateAddress(UpdateUserAddressRequest $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->userAddressService->updateAddressForUser($user->id, $id, $request->validated() + [
            'is_default' => $request->has('is_default')
        ]);

        return redirect()->back()->with('success', 'Cập nhật địa chỉ nhận hàng thành công.');
    }

    /**
     * Delete a shipping address.
     */
    public function deleteAddress($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->userAddressService->deleteAddressForUser($user->id, $id);

        return redirect()->back()->with('success', 'Xóa địa chỉ nhận hàng thành công.');
    }

    /**
     * Set a shipping address as default.
     */
    public function setDefaultAddress($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->userAddressService->setDefaultAddressForUser($user->id, $id);

        return redirect()->back()->with('success', 'Thiết lập địa chỉ mặc định thành công.');
    }
}
