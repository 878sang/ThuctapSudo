<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getFilteredCategories(Request $request);
    public function getOtherCategories(int $id);
    public function getActiveWithChildren();
}
