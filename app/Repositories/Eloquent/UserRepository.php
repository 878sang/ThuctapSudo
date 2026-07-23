<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function getAllUserAdmin(Request $request, int $perPage = 10)
    {
        $query = $this->model->withTrashed();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        return $query->paginate($perPage)->withQueryString();
    }
    public function getUserWithOrders(int $userId)
    {
        return $this->model->withTrashed()
            ->with(['orders' => function ($query) {
                $query->latest();
            }])
            ->findOrFail($userId);
    }
}
