<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAll()
    {
        return Category::where('status', 1)->get();
    }

    public function getById($id)
    {
        return Category::find($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        $category = Category::find($id);

        if (!$category) {
            return null;
        }

        $category->update($data);

        return $category;
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return false;
        }

        return $category->update([
            'status' => 0
        ]);
    }
}
