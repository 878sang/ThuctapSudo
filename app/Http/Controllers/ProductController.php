<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::active()->get();
        $query = Product::withTrashed()->with('category');
        if ($request->has('category') && $request->category !== 'all') {
            $query->ofCategory($request->category);
        }
        if ($request->has('status') && $request->status !== 'all') {
            $query->filterStatus($request->status);
        }
        if (in_array($request->sort, ['asc', 'desc'])) {
            $query->orderAsc($request->sort);
        }
        if ($request->has('search')) {
            $query->search($request->search);
        }
        if ($request->has('action')) {
            $query->filterTrash($request->action);
        }

        $products = $query->paginate(10)->withQueryString();
        return view('Products.index', compact('products', 'categories'));
    }
    public function create()
    {
        $categories = Categories::where('status', 1)->get();
        return view('Products.create', compact('categories'));
    }
    public function store(StoreProductRequest $request)
    {
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

    public function update(UpdateProductRequest $request, string $id)
    {
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
