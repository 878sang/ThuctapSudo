<?php

namespace App\Services;

use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        return $this->userRepository->create([
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'dob' => $dob,
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);
    }
}
