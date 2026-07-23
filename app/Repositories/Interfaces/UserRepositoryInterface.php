<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllUserAdmin(Request $request, int $perPage = 10);
}
