<?php

namespace App\Http\Services;

use App\Http\Repositories\ChildRepository;
use App\Models\Child;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChildService
{
    protected $childRepository;

    public function __construct(ChildRepository $childRepository)
    {
        $this->childRepository = $childRepository;
    }

    public function getAllChild(): Collection
    {
        return $this->childRepository->getAll();
    }

    public function getChildDetail(string $id): Child
    {
        $child = $this->childRepository->getDetailById($id);

        if (!$child) {
            throw new ModelNotFoundException('Data anak tidak ditemukan.');
        }

        return $child;
    }
}
