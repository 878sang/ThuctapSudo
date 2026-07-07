<?php

namespace App\Services;

use App\Services\BaseService;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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
    #[Override]
    public function create(array $data, Request $request)
    {
        $data['avatar'] = $this->uploadFile($request, 'avatar', 'images');
        $data['slug'] = Str::slug($request->name);
        return parent::create($data, $request);
    }
    #[Override]
    public function update(array $data,  Request $request, int $id)
    {
        $category = $this->repository->findOrFail($id);
        $data['avatar'] = $this->uploadFile($request, 'avatar', 'images');
        $data['slug'] = Str::slug($request->name);
        return parent::update($data, $request, $id);
    }
    #[Override]
    public function delete(int $id, ?Request $request = null)
    {
        $category = $this->repository->withTrashed($id);
        $option = $request->option;
        if ($option === 'move_products_and_delete_category') {
            $this->productService->moveProductsToNewCategory($id, $request->new_category_id);
        }
        if ($option === 'delete_products_and_category') {
            $this->productService->deleteByCategoryId($id);
        }
        if ($category->trashed()) {
            return  $this->repository->forceDelete($id);
        }
        return parent::delete($id, $request);
    }
}
