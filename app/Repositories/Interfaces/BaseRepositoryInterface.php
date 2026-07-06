<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function getAll();
    public function paginate(int $perPage);
    public function find(int $id);
    public function findOrFail(int $id);
    public function create(array $data);
    public function update(array $data, int $id);
    public function onlyTrashed(int $id);
    public function withTrashed(int $id);
    public function delete(int $id);
    public function forceDelete(int $id);
    public function restore(int $id);
    public function first();
    public function firstOrCreate(array $data);
    public function updateOrCreate(array $data);
    public function count();
    public function exists();
    public function where(...$data);
    public function whereIn(string $column, array $values);
    public function with(array $data);
    public function orderBy(...$args);
}
