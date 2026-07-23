<?php

namespace App\Services;

use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Override;

/**
 * @property UserRepositoryInterface $repository
 */
class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct($userRepository);
    }

    public function loginClient(array $data, bool $remember = false): bool
    {
        $login = $data['login'];
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $field => $login,
            'password' => $data['password'],
            'role' => 'customer',
        ];

        return Auth::attempt($credentials, $remember);
    }

    public function loginAdmin(array $data, bool $remember = false): bool
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
        $user = $this->repository->where('email', $data['email'])->first();
        if ($user && in_array($user->role, ['super_admin', 'staff'])) {
            return Auth::attempt($credentials, $remember);
        }

        return false;
    }
    #[Override]
    public function create(array $data)
    {
        $dob = $data['dob'] ?? ($data['year'] . '-' . sprintf('%02d', $data['month']) . '-' . sprintf('%02d', $data['day']));

        $userData = [
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'dob' => $dob,
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'customer',
        ];

        if (request()->hasFile('avatar')) {
            $userData['avatar'] = $this->uploadFile(request(), 'avatar', 'avatars');
        }

        return $this->repository->create($userData);
    }
    #[Override]
    public function update(array $data, int $userId)
    {
        $dob = $data['dob'] ?? ($data['dob_year'] . '-' . sprintf('%02d', $data['dob_month']) . '-' . sprintf('%02d', $data['dob_day']));

        $updateData = [
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'dob' => $dob,
            'gender' => $data['gender'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        if (isset($data['role'])) {
            $updateData['role'] = $data['role'];
        }

        $columns = Schema::getColumnListing('users');
        if (in_array('avatar', $columns)) {
            $user = $this->repository->findOrFail($userId);
            if (request()->hasFile('avatar') && !empty($user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            $updateData['avatar'] = $this->uploadFile(request(), 'avatar', 'avatars', $user->avatar);
        }

        return $this->repository->update($updateData, $userId);
    }
    #[Override]
    public function delete(int $id, array $options = [])
    {
        $data = $this->repository->withTrashed($id);
        if ($data->deleted_at) {
            $this->repository->forceDelete($id);
            return redirect()->route('admin.users.index')->with('success', 'Xóa vĩnh viễn thành công!');
        }
        return parent::delete($id);
    }
    public function changePassword(int $userId, array $data): bool
    {
        $user = $this->repository->find($userId);
        if (!$user) {
            return false;
        }

        if (!Hash::check($data['old_password'], $user->password)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'old_password' => 'Mật khẩu cũ không chính xác.'
            ]);
        }

        return (bool) $this->repository->update([
            'password' => Hash::make($data['password'])
        ], $userId);
    }
    public function getAllUserAdmin(Request $request, int $perPage = 10)
    {
        return $this->repository->getAllUserAdmin($request, $perPage);
    }
}
