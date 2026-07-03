<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->status == 'active') {
            $categories = Categories::get();
        } elseif ($request->status == 'trash') {
            $categories = Categories::onlyTrashed()->get();
        } else {
            $categories = Categories::withTrashed()->get();
        }
        return view('categories.index', compact('categories'));
    }
    public function show(string $id)
    {
        $category = Categories::with('products')->findOrFail($id);
        return view('categories.detail', compact('category'));
    }
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required',
            ],
            [
                'name.required' => 'Tên danh mục là bắt buộc',
                'description.required' => 'Mô tả danh mục là bắt buộc',
                'avatar.required' => 'Ảnh danh mục là bắt buộc',
                'avatar.max' => 'Ảnh danh mục không được vượt quá 2MB',
                'avatar.mimes' => 'Ảnh danh mục phải là định dạng jpeg,png,jpg,gif',
                'status.required' => 'Trạng thái danh mục là bắt buộc',
            ],
            ['message' => 'Thông tin danh mục không chính xác.']
        );
        $filename = null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $filename, 'public');
        }
        $category = Categories::create([
            'name' => $request->name,
            'description' => $request->description,
            'avatar' => $filename,
            'status' => $request->status,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được thêm thành công!');
    }
    public function edit($id)
    {
        $category = Categories::find($id);
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $category = Categories::find($id);
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required',
            ],
            [
                'name.required' => 'Tên danh mục là bắt buộc',
                'description.required' => 'Mô tả danh mục là bắt buộc',
                'avatar.max' => 'Ảnh danh mục không được vượt quá 2MB',
                'avatar.mimes' => 'Ảnh danh mục phải là định dạng jpeg,png,jpg,gif',
                'status.required' => 'Trạng thái danh mục là bắt buộc',
            ],
            ['message' => 'Thông tin danh mục không chính xác.']
        );
        $filename = $category->avatar;
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete('images/' . $category->avatar);
            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $filename, 'public');
        }
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'avatar' => $filename,
            'status' => $request->status,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
    public function restore($id)
    {
        $category = Categories::onlyTrashed()->find($id);
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Danh mục không tồn tại.');
        }
        $category->restore();
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được khôi phục thành công.');
    }
    public function checkHasProducts(Request $request, $id)
    {
        $category = Categories::find($id);
        if ($category->products()->withTrashed()->count() > 0) {
            $otherCategories = Categories::where('id', '!=', $id)->get();
            return response()->json([
                'has_products' => true,
                'other_categories' => $otherCategories,
            ]);
        } else {
            return response()->json([
                'has_products' => false,
            ]);
        }
    }
    public function destroy(Request $request, $id)
    {
        $category = Categories::withTrashed()->findOrFail($id);

        $option = $request->option;
        if ($option === 'move_products_and_delete_category') {

            Product::withTrashed()->where('category_id', $id)
                ->update([
                    'category_id' => $request->new_category_id
                ]);
        }
        if ($option === 'delete_products_and_category') {

            Product::where('category_id', $id)->delete();
        }
        if ($category->trashed()) {
            $category->forceDelete();
            return redirect()->route('categories.index')->with('success', 'Danh mục đã được xóa thành công.');
        } else {
            $category->delete();
        }
        return response()->json([
            'success' => true
        ]);
    }
}
