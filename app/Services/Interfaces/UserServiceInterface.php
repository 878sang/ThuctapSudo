<?php

namespace App\Services\Interfaces;


interface UserServiceInterface extends BaseServiceInterface
{
    public function loginClient(array $data, bool $remember = false): bool;
    public function loginAdmin(array $data, bool $remember = false): bool;
    public function registerClient(array $data);
    public function updateProfile(int $userId, array $data);
    public function changePassword(int $userId, array $data): bool;
}
