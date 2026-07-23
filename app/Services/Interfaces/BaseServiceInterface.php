<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface BaseServiceInterface
{
    public function getAll();
    public function getActive();
    public function paginate(int $perpage = 10);
    public function find($id);
    public function findOrFail($id);
    public function onlyTrashed(int $id);
    public function withTrashed(int $id);
    public function create(array $data);
    public function with(array $data);
    public function where(...$data);
    public function update(array $data, int $id);
    public function delete(int $id, array $options = []);
    public function restore(int $id);
    public function forceDelete(int $id);
}
