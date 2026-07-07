<?php

namespace App\Services;

use App\Services\BaseService;
use App\Services\Interfaces\ProductServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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
    #[Override]
    public function create(array $data, Request $request)
    {
        $data['slug'] = Str::slug($request->name);

        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('images', $avatarName, 'public');
        }
        $data['avatar'] = $avatarName;

        $imageNames = [];
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $key => $image) {
                $imageName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                $image->storeAs('products', $imageName, 'public');
                $imageNames[] = $imageName;
            }
        }
        $data['images'] = $imageNames;
        return parent::create($data, $request);
    }
    #[Override]
    public function update(array $data, Request $request, int $id)
    {
        $product = $this->repository->findOrFail($id);

        $avatarName = $product->avatar;
        if ($request->hasFile('avatar')) {
            if ($product->avatar) {
                Storage::disk('public')->delete('images/' . $product->avatar);
            }
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('images', $avatarName, 'public');
        }
        $data['avatar'] = $avatarName;

        $imageNames = $product->images;
        if ($request->hasFile('images')) {
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete('products/' . $image);
                }
            }
            $imageNames = [];
            $images = $request->file('images');
            foreach ($images as $key => $image) {
                $imageName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                $image->storeAs('products', $imageName, 'public');
                $imageNames[] = $imageName;
            }
        }
        $data['images'] = $imageNames;
        $data['slug'] = Str::slug($request->name);
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
