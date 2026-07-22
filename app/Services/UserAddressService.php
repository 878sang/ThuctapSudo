<?php

namespace App\Services;

use App\Services\Interfaces\UserAddressServiceInterface;
use App\Repositories\Interfaces\UserAddressRepositoryInterface;

class UserAddressService extends BaseService implements UserAddressServiceInterface
{
    protected UserAddressRepositoryInterface $userAddressRepository;

    public function __construct(UserAddressRepositoryInterface $userAddressRepository)
    {
        parent::__construct($userAddressRepository);
        $this->userAddressRepository = $userAddressRepository;
    }

    public function getAddressesForUser(int $userId)
    {
        return $this->userAddressRepository->where('user_id', $userId)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function storeAddressForUser(int $userId, array $data)
    {
        $addressCount = $this->userAddressRepository->where('user_id', $userId)->count();
        $isDefault = (isset($data['is_default']) && $data['is_default']) || $addressCount === 0;

        if ($isDefault) {
            $this->userAddressRepository->where('user_id', $userId)->update(['is_default' => false]);
        }

        $data['user_id'] = $userId;
        $data['is_default'] = $isDefault;

        return $this->userAddressRepository->create($data);
    }

    public function updateAddressForUser(int $userId, int $addressId, array $data)
    {
        $address = $this->userAddressRepository->where('user_id', $userId)->findOrFail($addressId);
        $addressCount = $this->userAddressRepository->where('user_id', $userId)->count();
        $isDefault = (isset($data['is_default']) && $data['is_default']) || $addressCount === 1;

        if ($isDefault) {
            $this->userAddressRepository->where('user_id', $userId)
                ->where('id', '!=', $addressId)
                ->update(['is_default' => false]);
        }

        $data['is_default'] = $isDefault;
        $address->update($data);
        return $address;
    }

    public function deleteAddressForUser(int $userId, int $addressId)
    {
        $address = $this->userAddressRepository->where('user_id', $userId)->findOrFail($addressId);
        $wasDefault = $address->is_default;

        $address->delete();

        if ($wasDefault) {
            $firstRemaining = $this->userAddressRepository->where('user_id', $userId)->first();
            if ($firstRemaining) {
                $firstRemaining->update(['is_default' => true]);
            }
        }

        return true;
    }

    public function setDefaultAddressForUser(int $userId, int $addressId)
    {
        $this->userAddressRepository->where('user_id', $userId)->update(['is_default' => false]);

        $address = $this->userAddressRepository->where('user_id', $userId)->findOrFail($addressId);
        $address->update(['is_default' => true]);

        return $address;
    }
    public function getDefaultAddressForUser(?int $userId)
    {
        return $this->userAddressRepository->where('user_id', $userId)->where('is_default', true)->first();
    }
}
