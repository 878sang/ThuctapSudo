<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $product)
    {
        $this->model = $product;
    }
    public function getFilteredProducts(array $filters, int $perPage = 10)
    {
        $query = $this->model->query();
        if (isset($filters['category']) && $filters['category'] !== 'all') {
            $query->ofCategory($filters['category']);
        }
        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $query->filterStatus($filters['status']);
        }
        if (isset($filters['sort']) && in_array($filters['sort'], ['asc', 'desc'])) {
            if ($filters['sort'] === 'desc') {
                $query->orderDesc();
            } else {
                $query->orderAsc();
            }
        }

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['action'])) {
            $query->filterTrash($filters['action']);
        }
        return $query->paginate($perPage)->withQueryString();
    }
    public function deleteByCategoryId(int $categoryId)
    {
        return $this->model->withTrashed()->where('category_id', $categoryId)->delete();
    }
    public function moveProductsToNewCategory(int $oldCategoryId, int $newCategoryId)
    {
        return $this->model->withTrashed()->where('category_id', $oldCategoryId)->update(['category_id' => $newCategoryId]);
    }
}
