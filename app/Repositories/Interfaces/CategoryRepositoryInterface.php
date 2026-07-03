<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function getAll();
    public function getFilteredCategories(Request $request);
    public function getById($id);
    public function getWithProducts($id);
    public function getOnlyTrashed($id);
    public function getWithTrashed($id);
    public function create(array $data);
    public function update(array $data, $id);
    public function getOtherCategories(int $id);
    public function restore(int $id);
    public function forceDelete(int $id);
    public function delete($id);
}
