<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;


interface ProductServiceInterface extends BaseServiceInterface
{
    public function getFilteredProducts(Request $request, int $perPage = 10);
    public function deleteByCategoryId(int $categoryId);
    public function moveProductsToNewCategory(int $oldCategoryId, int $newCategoryId);
    public function getProductsByCategory(int $categoryId);
    public function getProductsByBrand(int $brandId, int $id, int $limit = 6);
    public function generateSlug(string $name): string;
}
