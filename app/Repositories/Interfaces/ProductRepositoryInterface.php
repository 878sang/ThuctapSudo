<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getFilteredProducts(array $filters, int $perPage = 10);
    public function deleteByCategoryId(int $categoryId);
    public function moveProductsToNewCategory(int $oldCategoryId, int $newCategoryId);
    public function getProductsByCategory(int $categoryId);
    public function getProductsByBrand(int $brandId, int $id, int $limit = 6);
}
