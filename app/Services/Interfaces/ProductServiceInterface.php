<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;


interface ProductServiceInterface extends BaseServiceInterface
{
    public function getFilteredProducts(Request $request, int $perPage = 10);
    public function deleteByCategoryId(int $categoryId);
    public function moveProductsToNewCategory(int $oldCategoryId, int $newCategoryId);
    public function generateSlug(string $name): string;
}
