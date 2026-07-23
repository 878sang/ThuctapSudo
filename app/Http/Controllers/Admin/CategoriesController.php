<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
    protected CategoryServiceInterface $categoryService;
    protected ProductServiceInterface $productService;
    public function __construct(CategoryServiceInterface $categoryService, ProductServiceInterface $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $categories = $this->categoryService->getFilteredCategories($request);
        return view('admin.Categories.index', [
            'categories' => CategoryResource::collection($categories)
        ]);
    }
    public function show(string $id)
    {
        $category = $this->categoryService->with(['products'])->findOrFail($id);
        return view('admin.Categories.detail', [
            'category' => new CategoryResource($category)
        ]);
    }
    public function create()
    {
        return view('admin.Categories.create');
    }
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $this->categoryService->create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được thêm thành công!');
    }
    public function edit($id)
    {
        $category = $this->categoryService->findOrFail($id);
        return view('admin.Categories.edit', compact('category'));
    }
    public function update(UpdateCategoryRequest $request, int  $id)
    {
        $data = $request->validated();
        $this->categoryService->update($data, $id);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
    public function restore($id)
    {
        $this->categoryService->restore($id);
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được khôi phục thành công.');
    }
    public function checkHasProducts(Request $request, $id)
    {
        $otherCategories = $this->categoryService->getOtherCategories($id);
        $hasProducts = $this->productService->where('category_id', $id)->withTrashed()->count() > 0;

        return response()->json([
            'has_products' => $hasProducts,
            'other_categories' => $otherCategories,
        ]);
    }
    public function destroy(Request $request, $id)
    {
        $this->categoryService->delete($id, $request->only(['option', 'new_category_id']));
        return response()->json([
            'success' => true
        ]);
    }
}

