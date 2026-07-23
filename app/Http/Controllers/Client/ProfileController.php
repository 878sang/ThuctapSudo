<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserAddressRequest;
use App\Http\Requests\UpdateUserAddressRequest;
use App\Services\Interfaces\UserAddressServiceInterface;
use App\Services\Interfaces\OrderServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;

use App\Services\Interfaces\CouponServiceInterface;

class ProfileController extends Controller
{
    protected UserAddressServiceInterface $userAddressService;
    protected OrderServiceInterface $orderService;
    protected UserServiceInterface $userService;
    protected CouponServiceInterface $couponService;

    public function __construct(
        UserAddressServiceInterface $userAddressService,
        OrderServiceInterface $orderService,
        UserServiceInterface $userService,
        CouponServiceInterface $couponService
    ) {
        $this->userAddressService = $userAddressService;
        $this->orderService = $orderService;
        $this->userService = $userService;
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $user  = Auth::user();
        $stats = $this->orderService->getOverviewStats($user->id);

        $ordersData = $this->orderService->getOrdersByUser($user->id);

        return view('client.profile.overview', array_merge(
            compact('user', 'ordersData'),
            $stats
        ));
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
        $user = Auth::user();
        $addresses = $this->userAddressService->getAddressesForUser($user->id);

        return view('client.profile.addresses', compact('user', 'addresses'));
    }
    public function storeAddress(StoreUserAddressRequest $request)
    {
        $user = Auth::user();

        $this->userAddressService->storeAddressForUser($user->id, $request->validated() + [
            'is_default' => $request->has('is_default')
        ]);

        return redirect()->back()->with('success', 'Thêm địa chỉ nhận hàng mới thành công.');
    }

    public function updateAddress(UpdateUserAddressRequest $request, $id)
    {
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

    /**
     * Show the account information form.
     */
    public function editInfo()
    {
        $user = Auth::user();
        return view('client.profile.info', compact('user'));
    }

    /**
     * Update the user profile information.
     */
    public function updateInfo(UpdateProfileRequest $request)
    {
        $this->userService->updateProfile(Auth::id(), $request->validated());

        return redirect()->back()->with('success', 'Cập nhật thông tin tài khoản thành công.');
    }

    /**
     * Show the order management page.
     */
    public function orders(Request $request)
    {
        $user = Auth::user();
        $filters = $request->only(['status', 'start_date', 'end_date', 'search']);
        $orders = $this->orderService->getPaginatedOrdersByUser($user->id, $filters, 10);

        return view('client.profile.orders', compact('user', 'orders'));
    }

    /**
     * Show the order detail page.
     */
    public function showOrder($id)
    {
        $user = Auth::user();

        $order = \App\Models\Order::with(['items.product'])->where('user_id', $user->id)->find($id);
        return view('client.profile.order_detail', compact('user', 'order'));
    }

    /**
     * Show the quotes management page.
     */
    public function quotes(Request $request)
    {
        $user = Auth::user();

        $quotesData = [
            [
                'id' => 1,
                'code' => '#0123456',
                'sent_date' => '15/07/2024',
                'status' => 'pending',
                'status_label' => 'Chưa phản hồi',
                'quote_date' => '',
                'total_price' => '',
                'quoted_by_name' => '',
                'quoted_by_phone' => '',
            ],
            [
                'id' => 2,
                'code' => '#0123456',
                'sent_date' => '15/07/2024',
                'status' => 'quoted',
                'status_label' => 'Đã báo giá',
                'quote_date' => '18/07/2024',
                'total_price' => 135000000,
                'quoted_by_name' => 'Admin',
                'quoted_by_phone' => '0973924463',
            ],
            [
                'id' => 3,
                'code' => '#0123456',
                'sent_date' => '15/07/2024',
                'status' => 'quoted',
                'status_label' => 'Đã báo giá',
                'quote_date' => '18/07/2024',
                'total_price' => 135000000,
                'quoted_by_name' => 'Admin',
                'quoted_by_phone' => '0973924463',
            ],
            [
                'id' => 4,
                'code' => '#0123456',
                'sent_date' => '15/07/2024',
                'status' => 'quoted',
                'status_label' => 'Đã báo giá',
                'quote_date' => '18/07/2024',
                'total_price' => 135000000,
                'quoted_by_name' => 'Admin',
                'quoted_by_phone' => '0973924463',
            ],
            [
                'id' => 5,
                'code' => '#0123456',
                'sent_date' => '15/07/2024',
                'status' => 'quoted',
                'status_label' => 'Đã báo giá',
                'quote_date' => '18/07/2024',
                'total_price' => 135000000,
                'quoted_by_name' => 'Admin',
                'quoted_by_phone' => '0973924463',
            ],
            [
                'id' => 6,
                'code' => '#0123456',
                'sent_date' => '15/07/2024',
                'status' => 'quoted',
                'status_label' => 'Đã báo giá',
                'quote_date' => '18/07/2024',
                'total_price' => 135000000,
                'quoted_by_name' => 'Admin',
                'quoted_by_phone' => '0973924463',
            ],
            [
                'id' => 7,
                'code' => '#0123456',
                'sent_date' => '15/07/2024',
                'status' => 'quoted',
                'status_label' => 'Đã báo giá',
                'quote_date' => '18/07/2024',
                'total_price' => 135000000,
                'quoted_by_name' => 'Admin',
                'quoted_by_phone' => '0973924463',
            ],
            [
                'id' => 8,
                'code' => '#0123456',
                'sent_date' => '15/07/2024',
                'status' => 'quoted',
                'status_label' => 'Đã báo giá',
                'quote_date' => '18/07/2024',
                'total_price' => 135000000,
                'quoted_by_name' => 'Admin',
                'quoted_by_phone' => '0973924463',
            ],
        ];

        return view('client.profile.quotes', compact('user', 'quotesData'));
    }

    /**
     * Show the change password page.
     */
    public function changePassword()
    {
        $user = Auth::user();
        return view('client.profile.password', compact('user'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $this->userService->changePassword(Auth::id(), $request->validated());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors(), 'update_password');
        }

        $user = Auth::user();
        if ($user) {
            Auth::login($user);
        }

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công.');
    }
    public function points()
    {
        $user = Auth::user();

        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 9;

        // Generate mock points transactions
        $items = [];
        for ($i = 0; $i < 90; $i++) {
            $items[] = (object)[
                'is_unread' => ($currentPage == 2 && $i == 9), // First item of page 2 (index 9) is unread
                'points' => 100,
                'code' => 'HL0123456789',
                'time' => '1 phút trước',
                'from' => 'Admin'
            ];
        }

        $currentPageItems = array_slice($items, ($currentPage - 1) * $perPage, $perPage);

        $points = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            count($items),
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('client.profile.points', compact('user', 'points'));
    }

    /**
     * Show the discount codes page.
     */
    public function vouchers()
    {
        $user = Auth::user();
        $validCoupons = $this->couponService->getValidCouponsForUser($user->id, 9);

        return view('client.profile.vouchers', compact('user', 'validCoupons'));
    }

    /**
     * Show the notifications page.
     */
    public function notifications()
    {
        $user = Auth::user();

        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 9;

        $activeTab = request()->get('tab', 'all');

        // Generate mock notifications
        $items = [];
        for ($i = 0; $i < 155; $i++) {
            $isUnread = ($i === 9); // First item on page 2 (index 9) is unread

            if ($activeTab === 'unread' && !$isUnread) {
                continue;
            }

            $localIdx = $i % 9;
            $htmlText = '';
            if ($localIdx === 0) {
                $htmlText = 'Cập nhật hệ thống từ 10:00 29/10/2023 đến 10:00 29/10/2023 đến';
            } else if ($localIdx === 1) {
                $htmlText = 'Bạn đã đạt đến giới hạn mua hàng trong tháng này';
            } else {
                $htmlText = 'Đơn hàng <span class="font-bold text-[#FF9500] font-sans">HP01253</span> đã được mua thành công, xin chúc mừng bạn';
            }

            $items[] = (object)[
                'is_unread' => $isUnread,
                'html' => $htmlText,
                'time' => '1 phút trước',
                'from' => 'Admin'
            ];
        }

        $currentPageItems = array_slice($items, ($currentPage - 1) * $perPage, $perPage);

        $notifications = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $activeTab === 'unread' ? 1 : 155,
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()]
        );

        $notifications->appends(['tab' => $activeTab]);

        return view('client.profile.notifications', compact('user', 'notifications', 'activeTab'));
    }
}
