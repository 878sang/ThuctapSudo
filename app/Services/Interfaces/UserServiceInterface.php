<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface UserServiceInterface extends BaseServiceInterface
{
    public function loginClient(array $data, bool $remember = false): bool;
    public function loginAdmin(array $data, bool $remember = false): bool;
    public function changePassword(int $userId, array $data): bool;
    public function getAllUserAdmin(Request $request, int $perPage = 10);
}
