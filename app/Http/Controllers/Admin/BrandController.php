<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\Interfaces\BrandServiceInterface;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected BrandServiceInterface $brandService;
    public function __construct(BrandServiceInterface $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        $brands = $this->brandService->getFilteredBrands($request, 10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();
        $this->brandService->create($data, $request);
        return redirect()->route('admin.brands.index')->with('success', 'Tạo thương hiệu thành công.');
    }

    public function show(string $slug, int $id)
    {
        $brand = $this->brandService->findOrFail($id);
        return view('admin.brands.detail', compact('brand'));
    }

    public function edit(int $id)
    {
        $brand = $this->brandService->findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, int  $id)
    {
        $data = $request->validated();
        $this->brandService->update($data, $request, $id);
        return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công.');
    }

    public function restore(int $id)
    {
        $this->brandService->restore($id);
        return redirect()->route('admin.brands.index')->with('success', 'Khôi phục thương hiệu thành công.');
    }

    public function destroy(int $id)
    {
        $this->brandService->delete($id);
        return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công.');
    }
}

