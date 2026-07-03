<?php

namespace App\Repositories\Eloquent;

use App\Models\Categories;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected Categories $category;
    public function __construct(Categories $category)
    {
        $this->category = $category;
    }
    public function getAll()
    {
        return $this->category::active()->paginate(10);
    }
    public function getFilteredCategories(Request $request)
    {
        $categories = $this->category::query();
        if ($request->status == 'active') {
            $categories->active();
        } elseif ($request->status == 'trash') {
            $categories->onlyTrashed();
        } else {
            $categories->withTrashed();
        }
        return $categories->paginate(5);
    }
    public function getWithProducts($id)
    {
        return $this->category::with('products')->findOrFail($id);
    }
    public function getWithTrashed($id)
    {
        return $this->category::withTrashed()->find($id);
    }
    public function getOnlyTrashed($id)
    {
        return $this->category::onlyTrashed()->find($id);
    }
    public function getById($id)
    {
        return $this->category::find($id);
    }
    public function create(array $data)
    {
        return $this->category::create($data);
    }
    public function update(array $data, $id)
    {
        return $this->category::where('id', $id)->update($data);
    }
    public function getOtherCategories(int $id)
    {
        return $this->category::where('id', '!=', $id)->get();
    }
    public function restore(int $id)
    {
        $category = $this->getOnlyTrashed($id);
        return $category->restore();
    }
    public function forceDelete($id)
    {
        return $this->category::where('id', $id)->forceDelete();
    }
    public function delete($id)
    {
        return $this->category::where('id', $id)->delete();
    }
}
