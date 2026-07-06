<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface CategoryServiceInterface extends BaseServiceInterface
{
    public function getFilteredCategories(Request $request);
    public function getOtherCategories(int $id);
}
