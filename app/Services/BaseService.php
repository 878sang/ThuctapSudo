<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface;

use Illuminate\Support\Facades\Storage;

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
    public function getActive()
    {
        return $this->repository->getActive();
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
    protected function uploadFile(Request $request, string $fieldName, string $directory, $oldFileName = null)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($directory, $fileName, 'public');
            return $fileName;
        }
        return $oldFileName;
    }
    protected function uploadMultipleFiles(Request $request, string $fieldName, string $directory, array $oldFileNames = [])
    {
        if ($request->hasFile($fieldName)) {
            foreach ($oldFileNames as $oldFile) {
                if (is_string($oldFile)) {
                    Storage::disk('public')->delete($directory . '/' . $oldFile);
                }
            }
            $fileNames = [];
            $files = $request->file($fieldName);
            foreach ($files as $key => $file) {
                $fileName = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->storeAs($directory, $fileName, 'public');
                $fileNames[] = $fileName;
            }
            return $fileNames;
        }
        return $oldFileNames;
    }
}

