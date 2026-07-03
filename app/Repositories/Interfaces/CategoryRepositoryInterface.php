<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function getAll();
    public function getFilteredCategories(Request $request);
    public function getById(int $id);
    public function getWithProducts(int $id);
    public function getOnlyTrashed(int $id);
    public function getWithTrashed(int $id);
    public function create(array $data);
    public function update(array $data, int $id);
    public function getOtherCategories(int $id);
    public function restore(int $id);
    public function forceDelete(int $id);
    public function delete(int $id);
}
