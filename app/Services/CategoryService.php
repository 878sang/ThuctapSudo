<?php

namespace App\Services;

use App\Services\BaseService;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Interfaces\ProductServiceInterface;
use Override;

/**
 * @property CategoryRepositoryInterface $repository
 * @property ProductServiceInterface $productService
 */
class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function __construct(CategoryRepositoryInterface $repository, ProductServiceInterface $productService)
    {
        parent::__construct($repository);
        $this->productService = $productService;
    }
    public function getFilteredCategories(Request $request)
    {
        return $this->repository->getFilteredCategories($request);
    }
    public function getOtherCategories(int $id)
    {
        return $this->repository->getOtherCategories($id);
    }
    public function getActiveWithChildren()
    {
        return $this->repository->getActiveWithChildren();
    }
    #[Override]
    public function create(array $data)
    {
        $data['avatar'] = $this->uploadFile(request(), 'avatar', 'images');
        $data['slug'] = Str::slug($data['name']);
        return parent::create($data);
    }
    #[Override]
    public function update(array $data, int $id)
    {
        $category = $this->repository->findOrFail($id);
        $data['avatar'] = $this->uploadFile(request(), 'avatar', 'images', $category->avatar);
        $data['slug'] = Str::slug($data['name']);
        return parent::update($data, $id);
    }
    #[Override]
    public function delete(int $id, array $options = [])
    {
        $category = $this->repository->withTrashed($id);
        $option = $options['option'] ?? null;
        if ($option === 'move_products_and_delete_category') {
            $this->productService->moveProductsToNewCategory($id, $options['new_category_id'] ?? null);
        }
        if ($option === 'delete_products_and_category') {
            $this->productService->deleteByCategoryId($id);
        }
        if ($category->trashed()) {
            return  $this->repository->forceDelete($id);
        }
        return parent::delete($id, $options);
    }
}
