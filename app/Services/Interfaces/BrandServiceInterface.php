<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface BrandServiceInterface extends BaseServiceInterface
{
    public function getFilteredBrands(Request $request, int $perPage = 10);
}
