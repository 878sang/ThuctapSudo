<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use Illuminate\Http\Request;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function __construct(Brand $brand)
    {
        $this->model = $brand;
    }
    public function getFilteredBrands(Request $request, int $perPage = 10)
    {
        $brands = $this->model::query();
        if ($request->has('trash')) {
            $brands->onlyTrashed();
        }
        if ($request->status == 'active') {
            $brands->active();
        } elseif ($request->status == 'inactive') {
            $brands->where('status', Brand::STATUS_INACTIVE);
        }
        if ($request->search) {
            $brands->search($request->search);
        }
        return $brands->paginate($perPage);
    }
}
