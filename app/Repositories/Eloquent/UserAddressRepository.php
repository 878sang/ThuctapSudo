<?php

namespace App\Repositories\Eloquent;

use App\Models\UserAddress;
use App\Repositories\Interfaces\UserAddressRepositoryInterface;

class UserAddressRepository extends BaseRepository implements UserAddressRepositoryInterface
{
    public function __construct(UserAddress $userAddress)
    {
        $this->model = $userAddress;
    }
}
