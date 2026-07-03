<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->getAll();
        $filters = $request->only(['category', 'status', 'sort', 'search', 'action']);
        $products = $this->productRepository->getFilteredProducts($filters, 15);
        return view('Products.index', compact('products', 'categories'));
    }
    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        return view('Products.create', compact('categories'));
    }
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
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

        $this->productRepository->create($data);
        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }
    public function show(string $slug, string $id)
    {
        $product = $this->productRepository->getById($id);
        return view('Products.detail', compact('product'));
    }

    public function edit(string $id)
    {
        $product = $this->productRepository->getById($id);
        $categories = $this->categoryRepository->getAll();
        return view('Products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $data = $request->validated();
        $product = $this->productRepository->getById($id);

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

        $this->productRepository->update($data, $id);
        return redirect()->route('products.index')->with('success', 'Cập nhật thông tin sản phẩm thành công!');
    }

    public function restore(string $id)
    {
        $this->productRepository->restore($id);
        return redirect()->route('products.index')->with('success', 'Khôi phục sản phẩm thành công!');
    }
    public function destroy(string $id)
    {
        $product = $this->productRepository->findWithTrashed($id);
        if ($product->deleted_at) {
            $this->productRepository->forceDelete($id);
            return redirect()->route('products.index')->with('success', 'Xóa sản phẩm vĩnh viễn thành công!');
        }
        $this->productRepository->delete($id);
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
