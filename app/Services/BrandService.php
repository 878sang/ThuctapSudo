<?php

namespace App\Services;

use App\Repositories\Interfaces\BrandRepositoryInterface;
use App\Services\Interfaces\BrandServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Override;

/**
 * @property BrandRepositoryInterface $repository
 */
class BrandService extends BaseService implements BrandServiceInterface
{
    public function __construct(BrandRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
    public function getFilteredBrands(Request $request, int $perPage = 10)
    {
        return $this->repository->getFilteredBrands($request, $perPage);
    }
    #[Override]
    public function create(array $data, Request $request)
    {
        $data['logo'] = $this->uploadFile($request, 'logo', 'images');
        $data['slug'] = Str::slug($request->name);
        return parent::create($data, $request);
    }
    #[Override]
    public function update(array $data,  Request $request, int $id)
    {
        $brand = $this->repository->findOrFail($id);
        $data['logo'] = $this->uploadFile($request, 'logo', 'images', $brand->logo);
        $data['slug'] = Str::slug($request->name);
        return parent::update($data, $request, $id);
    }
    #[Override]
    public function delete(int $id, ?Request $request = null)
    {
        $data = $this->repository->withTrashed($id);
        if ($data->deleted_at) {
            $this->repository->forceDelete($id);
            return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu vĩnh viễn thành công!');
        }
        return parent::delete($id, $request);
    }
}

