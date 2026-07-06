<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface;

class BaseService implements BaseServiceInterface
{
    protected BaseRepositoryInterface $repository;
    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function getAll()
    {
        return $this->repository->getAll();
    }
    public function paginate(int $perpage = 10)
    {
        return $this->repository->paginate($perpage);
    }
    public function find($id)
    {
        return $this->repository->find($id);
    }
    public function findOrFail($id)
    {
        return $this->repository->findOrFail($id);
    }
    public function create(array $data, Request $request)
    {
        return $this->repository->create($data);
    }
    public function update(array $data, Request $request, int $id)
    {
        return $this->repository->update($data, $id);
    }
    public function onlyTrashed($id)
    {
        return $this->repository->onlyTrashed($id);
    }
    public function withTrashed($id)
    {
        return $this->repository->withTrashed($id);
    }
    public function with(array $data)
    {
        return $this->repository->with($data);
    }
    public function where(...$data)
    {
        return $this->repository->where(...$data);
    }
    public function delete(int $id, ?Request $request = null)
    {
        return $this->repository->delete($id);
    }
    public function restore($id)
    {
        return $this->repository->restore($id);
    }
    public function forceDelete($id)
    {
        return $this->repository->forceDelete($id);
    }
}
