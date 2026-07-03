<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function getAll();
    public function getFilteredProducts(array $filters, int $perPage = 10);
    public function getById($id);
    public function findWithTrashed(int $id);
    public function findOnlyTrashed(int $id);
    public function findWithCategory($id);
    public function create(array $data);
    public function update(array $data, $id);
    public function deleteByCategoryId(int $categoryId);
    public function moveProductsToNewCategory(int $oldCategoryId, int $newCategoryId);
    public function restore(int $id);
    public function forceDelete(int $id);
    public function delete($id);
}
