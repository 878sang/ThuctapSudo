<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\UserServiceInterface;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserAdminController extends Controller
{
    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAllUserAdmin($request, 10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        $this->userService->create($data);
        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng mới thành công.');
    }

    public function edit(int $id)
    {
        $user = $this->userService->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $data = $request->validated();
        $this->userService->update($data, $id);
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật thông tin người dùng thành công.');
    }

    public function destroy(int $id)
    {
        if ($id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        $user = $this->userService->withTrashed($id);

        if ($user->deleted_at) {
            if (!empty($user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            $this->userService->delete($id);
            return redirect()->route('admin.users.index')->with('success', 'Xóa vĩnh viễn người dùng thành công.');
        } else {
            $this->userService->delete($id);
            return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công.');
        }
    }

    public function restore(int $id)
    {
        $this->userService->restore($id);
        return redirect()->route('admin.users.index')->with('success', 'Khôi phục tài khoản thành công.');
    }
}
