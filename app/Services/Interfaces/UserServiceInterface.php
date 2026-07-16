<?php

namespace App\Services\Interfaces;

interface UserServiceInterface extends BaseServiceInterface
{
    public function login(array $data, bool $remember = false): bool;
    public function register(array $data);
}
