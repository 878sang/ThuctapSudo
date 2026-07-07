<?php

namespace App\Services;

use App\Services\BaseService;
use App\Services\Interfaces\ProductServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Override;

/**
 * @property ProductRepositoryInterface $repository
 */
class ProductService extends BaseService implements ProductServiceInterface
{
    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
    public function getFilteredProducts(Request $request, int $perPage = 10)
    {
        $filters = $request->only(['category', 'status', 'sort', 'search', 'action']);
        return $this->repository->getFilteredProducts($filters, $perPage);
    }
    public function deleteByCategoryId(int $categoryId)
    {
        return $this->repository->deleteByCategoryId($categoryId);
    }
    public function moveProductsToNewCategory(int $oldCategoryId, int $newCategoryId)
    {
        return $this->repository->moveProductsToNewCategory($oldCategoryId, $newCategoryId);
    }
    public function generateSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        while ($this->repository->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        return $slug;
    }
    protected function validatePublish(array &$data, Request $request, ?Product $product = null, $avatarName = null)
    {
        if ($request->status == Product::STATUS_ACTIVE) {
            if (($data['stock'] ?? $product->stock) <= 0) {
                throw ValidationException::withMessages([
                    'stock' => 'Không thể xuất bản sản phẩm khi hết hàng.'
                ]);
            }
            if ($avatarName == null && $request->hasFile('thumbnail') == null) {
                throw ValidationException::withMessages([
                    'thumbnail' => 'Không thể xuất bản sản phẩm khi chưa có ảnh đại diện.'
                ]);
            }
            $data['published_at'] = now()->toDateTimeString();
        }
    }
    #[Override]
    public function create(array $data, Request $request)
    {
        $data['slug'] = $this->generateSlug($request->name);
        $this->validatePublish($data, $request);
        $data['thumbnail'] = $this->uploadFile($request, 'thumbnail', 'images');
        $data['gallery'] = $this->uploadMultipleFiles($request, 'gallery', 'products', $product->gallery ?? []);
        return parent::create($data, $request);
    }
    #[Override]
    public function update(array $data, Request $request, int $id)
    {
        $product = $this->repository->findOrFail($id);
        $this->validatePublish($data, $request, $product, $product->thumbnail);
        $data['thumbnail'] = $this->uploadFile($request, 'thumbnail', 'images', $product->thumbnail);
        $data['gallery'] = $this->uploadMultipleFiles($request, 'gallery', 'products', $product->gallery ?? []);
        $data['slug'] = $this->generateSlug($request->name);
        return parent::update($data, $request, $id);
    }
    #[Override]
    public function delete(int $id, ?Request $request = null)
    {
        $data = $this->repository->withTrashed($id);
        if ($data->deleted_at) {
            $this->repository->forceDelete($id);
            return redirect()->route('products.index')->with('success', 'Xóa sản phẩm vĩnh viễn thành công!');
        }
        return parent::delete($id, $request);
    }
}
