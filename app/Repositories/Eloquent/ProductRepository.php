<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    protected Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function getAll()
    {
        return $this->product::active()->paginate(10);
    }
    public function getFilteredProducts(array $filters, int $perPage = 10)
    {
        $query = $this->product::query();
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
    public function getById(int $id)
    {
        return $this->product::find($id);
    }
    public function findWithTrashed(int $id)
    {
        return $this->product::withTrashed()->find($id);
    }
    public function findOnlyTrashed(int $id)
    {
        return $this->product::onlyTrashed()->find($id);
    }
    public function findWithCategory(int $id)
    {
        return $this->product::with('category')->findOrFail($id);
    }
    public function create(array $data)
    {
        return $this->product::create($data);
    }
    public function update(array $data, int $id)
    {
        $product = $this->product::find($id);
        return $product ? $product->update($data) : false;
    }
    public function deleteByCategoryId(int $categoryId)
    {
        return $this->product::withTrashed()->where('category_id', $categoryId)->delete();
    }
    public function moveProductsToNewCategory(int $oldCategoryId, int $newCategoryId)
    {
        return $this->product::withTrashed()->where('category_id', $oldCategoryId)->update(['category_id' => $newCategoryId]);
    }
    public function restore(int $id)
    {
        $product = $this->findOnlyTrashed($id);
        return $product ? $product->restore() : false;
    }
    public function forceDelete(int $id)
    {
        $product = $this->product::withTrashed()->find($id);
        return $product ? $product->forceDelete() : false;
    }
    public function delete(int $id)
    {
        $product = $this->product::find($id);
        return $product ? $product->delete() : false;
    }
}
