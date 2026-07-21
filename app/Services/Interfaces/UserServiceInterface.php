<?php

namespace App\Services\Interfaces;

interface UserServiceInterface extends BaseServiceInterface
{
    public function loginClient(array $data, bool $remember = false): bool;
    public function loginAdmin(array $data, bool $remember = false): bool;
    public function registerClient(array $data);
}
