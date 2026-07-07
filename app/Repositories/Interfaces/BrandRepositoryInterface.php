<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{
    public function getFilteredBrands(Request $request, int $perPage = 10);
}
