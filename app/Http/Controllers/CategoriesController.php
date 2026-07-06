<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class CategoriesController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepository;
    protected ProductRepositoryInterface $productRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository, ProductRepositoryInterface $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->getFilteredCategories($request);

        return view('categories.index', compact('categories'));
    }
    public function show(string $id)
    {
        $category = $this->categoryRepository->with(['products'])->findOrFail($id);
        return view('categories.detail', compact('category'));
    }
    public function create()
    {
        return view('categories.create');
    }
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $fileName = null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $fileName, 'public');
        }
        $data['avatar'] = $fileName;
        $data['slug'] = Str::slug($request->name);
        $this->categoryRepository->create($data);
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được thêm thành công!');
    }
    public function edit($id)
    {
        $category = $this->categoryRepository->findOrFail($id);
        return view('categories.edit', compact('category'));
    }
    public function update(UpdateCategoryRequest $request, $id)
    {
        $data = $request->validated();
        $category = $this->categoryRepository->findOrFail($id);
        $fileName = $category->avatar;
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete('images/' . $category->avatar);
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $fileName, 'public');
            $data['avatar'] = $fileName;
        }
        $data['slug'] = Str::slug($request->name);
        $this->categoryRepository->update($data, $id);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
    public function restore($id)
    {
        $category = $this->categoryRepository->onlyTrashed($id);
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Danh mục không tồn tại.');
        }
        $this->categoryRepository->restore($id);
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được khôi phục thành công.');
    }
    public function checkHasProducts(Request $request, $id)
    {
        $otherCategories = $this->categoryRepository->getOtherCategories($id);
        $hasProducts = $this->productRepository->where('category_id', $id)->withTrashed()->count() > 0;

        return response()->json([
            'has_products' => $hasProducts,
            'other_categories' => $otherCategories,
        ]);
    }
    public function destroy(Request $request, $id)
    {
        $category = $this->categoryRepository->withTrashed($id);

        $option = $request->option;
        if ($option === 'move_products_and_delete_category') {

            $this->productRepository->moveProductsToNewCategory($id, $request->new_category_id);
        }
        if ($option === 'delete_products_and_category') {

            $this->productRepository->deleteByCategoryId($id);
        }
        if ($category->trashed()) {
            $this->categoryRepository->forceDelete($id);
            return redirect()->route('categories.index')->with('success', 'Danh mục đã được xóa thành công.');
        } else {
            $this->categoryRepository->delete($id);
        }
        return response()->json([
            'success' => true
        ]);
    }
}
