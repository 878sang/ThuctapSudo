<?php

namespace App\Repositories\Eloquent;

use App\Models\Categories;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Categories $category)
    {
        $this->model = $category;
    }
    public function getFilteredCategories(Request $request)
    {
        $categories = $this->model::query();
        if ($request->status == 'active') {
            $categories->active();
        } elseif ($request->status == 'trash') {
            $categories->onlyTrashed();
        } else {
            $categories->withTrashed();
        }
        return $categories->paginate(5);
    }
    public function getOtherCategories(int $id)
    {
        return $this->model->where('id', '!=', $id)->get();
    }
}

