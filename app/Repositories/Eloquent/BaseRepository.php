<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function getAll()
    {
        return $this->model->all();
    }

    public function paginate(int $perPage)
    {
        return $this->model->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete(int $id)
    {
        $data = $this->model->findOrFail($id);
        return $data->delete();
    }
    public function onlyTrashed(int $id)
    {
        return $this->model->onlyTrashed()->findOrFail($id);
    }
    public function withTrashed(int $id)
    {
        return $this->model->withTrashed()->findOrFail($id);
    }
    public function forceDelete(int $id)
    {
        $data = $this->model->onlyTrashed()->findOrFail($id);
        return $data->forceDelete();
    }

    public function restore(int $id)
    {
        $data = $this->model->onlyTrashed()->findOrFail($id);
        return $data->restore();
    }

    public function first()
    {
        return $this->model->first();
    }

    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function updateOrCreate(array $data)
    {
        return $this->model->updateOrCreate($data);
    }

    public function count()
    {
        return $this->model->count();
    }

    public function exists()
    {
        return $this->model->exists();
    }

    public function where(...$data)
    {
        return $this->model->where(...$data);
    }

    public function whereIn(string $column, array $values)
    {
        return $this->model->whereIn($column, $values);
    }

    public function with(array $data)
    {
        return $this->model->with($data);
    }

    public function orderBy(...$data)
    {
        return $this->model->orderBy($data);
    }
}
