<?php

namespace App\Services\Interfaces;

interface UserAddressServiceInterface extends BaseServiceInterface
{
    public function getAddressesForUser(int $userId);
    public function storeAddressForUser(int $userId, array $data);
    public function updateAddressForUser(int $userId, int $addressId, array $data);
    public function deleteAddressForUser(int $userId, int $addressId);
    public function setDefaultAddressForUser(int $userId, int $addressId);
    public function getDefaultAddressForUser(int $userId);
}
