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

    public function login(array $data, bool $remember = false): bool
    {
        $login = $data['login'];
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $field => $login,
            'password' => $data['password'],
            'role' => 'customer', // Chỉ cho phép khách hàng đăng nhập ở phía client
        ];

        return Auth::attempt($credentials, $remember);
    }

    public function register(array $data)
    {
        return $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);
    }
}
