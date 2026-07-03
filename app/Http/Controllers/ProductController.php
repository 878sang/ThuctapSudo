<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::where('status', 1)->select('id', 'name')->get();
        $query = Product::withTrashed()->with('category');
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if (in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('name', $request->sort);
        }
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->action == 'trash' && $request->action !== 'all') {
            $query->where('deleted_at', '!=', null);
        } else {
            $query->where('deleted_at', null);
        }

        $products = $query->paginate(10)->withQueryString();
        return view('Products.index', compact('products', 'categories'));
    }
    public function create()
    {
        $categories = Categories::where('status', 1)->get();
        return view('Products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'detail' => 'required|string',
                'status' => 'required|in:0,1',
            ],
            [
                'name.required' => 'Tên sản phẩm là bắt buộc',
                'description.required' => 'Mô tả sản phẩm là bắt buộc',
                'avatar.required' => 'Ảnh sản phẩm là bắt buộc',
                'avatar.max' => 'Ảnh sản phẩm không được vượt quá 2MB',
                'avatar.mimes' => 'Ảnh sản phẩm phải là định dạng jpeg,png,jpg,gif',
                'category_id.required' => 'Danh mục là bắt buộc',
                'category_id.exists' => 'Danh mục không tồn tại',
                'images.required' => 'Ảnh sản phẩm là bắt buộc',
                'images.max' => 'Ảnh sản phẩm không được vượt quá 2MB',
                'images.mimes' => 'Ảnh sản phẩm phải là định dạng jpeg,png,jpg,gif',
                'detail.required' => 'Chi tiết sản phẩm là bắt buộc',
                'status.required' => 'Trạng thái sản phẩm là bắt buộc',
            ],
            ['message' => 'Thông tin danh mục không chính xác.']
        );
        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('images', $avatarName, 'public');
        }

        $imageNames = [];
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $key => $image) {
                $imageName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                $image->storeAs('products', $imageName, 'public');
                $imageNames[] = $imageName;
            }
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'detail' => $request->detail,
            'avatar' => $avatarName,
            'images' => $imageNames,
            'status' => $request->status,
        ]);
        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }
    public function show(string $slug, string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('Products.detail', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Categories::where('status', 1)->get();
        return view('Products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'detail' => 'required|string',
                'status' => 'required|in:0,1',
            ],
            [
                'name.required' => 'Tên sản phẩm là bắt buộc',
                'description.required' => 'Mô tả sản phẩm là bắt buộc',
                'avatar.required' => 'Ảnh sản phẩm là bắt buộc',
                'avatar.max' => 'Ảnh sản phẩm không được vượt quá 2MB',
                'avatar.mimes' => 'Ảnh sản phẩm phải là định dạng jpeg,png,jpg,gif',
                'category_id.required' => 'Danh mục là bắt buộc',
                'category_id.exists' => 'Danh mục không tồn tại',
                'images.required' => 'Ảnh sản phẩm là bắt buộc',
                'images.max' => 'Ảnh sản phẩm không được vượt quá 2MB',
                'images.mimes' => 'Ảnh sản phẩm phải là định dạng jpeg,png,jpg,gif',
                'detail.required' => 'Chi tiết sản phẩm là bắt buộc',
                'status.required' => 'Trạng thái sản phẩm là bắt buộc',
            ],
            ['message' => 'Thông tin danh mục không chính xác.']
        );
        $product = Product::find($id);
        $avatarName = $product->avatar;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('images', $avatarName, 'public');
        }
        $imageNames = $product->images;
        if ($request->hasFile('images')) {
            $imageNames = [];
            $images = $request->file('images');
            foreach ($product->images as $image) {
                Storage::disk('public')->delete('products/' . $image);
            }
            foreach ($images as $key => $image) {
                $imageName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                $image->storeAs('products', $imageName, 'public');
                $imageNames[] = $imageName;
            }
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'detail' => $request->detail,
            'avatar' => $avatarName,
            'images' => $imageNames,
            'status' => $request->status,
        ]);
        return redirect()->route('products.index')->with('success', 'Cập nhật thông tin sản phẩm thành công!');
    }

    public function restore(string $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('products.index')->with('success', 'Khôi phục sản phẩm thành công!');
    }
    public function destroy(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        if ($product->deleted_at) {
            $product->forceDelete();
            return redirect()->route('products.index')->with('success', 'Xóa sản phẩm vĩnh viễn thành công!');
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
