<?php

namespace App\Services;

use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class UserService extends BaseService implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct($userRepository);
        $this->userRepository = $userRepository;
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
        $user = $this->userRepository->where('email', $data['email'])->first();
        if ($user && in_array($user->role, ['super_admin', 'staff'])) {
            return Auth::attempt($credentials, $remember);
        }

        return false;
    }

    public function registerClient(array $data)
    {
        $dob = $data['year'] . '-' . sprintf('%02d', $data['month']) . '-' . sprintf('%02d', $data['day']);

        $userData = [
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'dob' => $dob,
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ];

        if (request()->hasFile('avatar')) {
            $userData['avatar'] = $this->uploadFile(request(), 'avatar', 'avatars');
        }

        return $this->userRepository->create($userData);
    }

    public function updateProfile(int $userId, array $data)
    {
        $dob = $data['dob_year'] . '-' . sprintf('%02d', $data['dob_month']) . '-' . sprintf('%02d', $data['dob_day']);

        $updateData = [
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'dob' => $dob,
            'gender' => $data['gender'],
        ];

        $columns = Schema::getColumnListing('users');
        if (in_array('avatar', $columns)) {
            $user = $this->userRepository->findOrFail($userId);
            if (request()->hasFile('avatar') && !empty($user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            $updateData['avatar'] = $this->uploadFile(request(), 'avatar', 'avatars', $user->avatar);
        }

        return $this->userRepository->update($updateData, $userId);
    }

    public function changePassword(int $userId, array $data): bool
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            return false;
        }

        if (!Hash::check($data['old_password'], $user->password)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'old_password' => 'Mật khẩu cũ không chính xác.'
            ]);
        }

        return (bool) $this->userRepository->update([
            'password' => Hash::make($data['password'])
        ], $userId);
    }
}
