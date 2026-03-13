<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getAll(): Collection
    {
        return Category::where('status', 1)->get();
    }

    public function getById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function existsByName(string $name): bool
    {
        return Category::where('name', $name)->exists();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(int $id, array $data): ?Category
    {
        $category = Category::find($id);

        if (! $category) {
            return null;
        }

        $category->update($data);

        return $category;
    }

    public function delete(int $id): bool
    {
        $category = Category::find($id);

        if (! $category) {
            return false;
        }

        return $category->update([
            'status' => 0,
        ]);
    }
}
