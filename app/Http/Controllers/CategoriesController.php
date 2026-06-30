<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
        ]);
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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
        ]);
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
    public function destroy($id)
    {
        Categories::find($id)->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
