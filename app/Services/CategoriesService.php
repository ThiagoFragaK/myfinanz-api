<?php

namespace App\Services;

use App\Models\Categories;

class CategoriesService
{
    public function getList()
    {
        return Categories::select('id', 'name', 'description', 'icon', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getCategoryById(int $id)
    {
        return Categories::find($id);
    }

    public function createCategory(string $name, string $description, string $icon)
    {
        return Categories::create([
            'name' => $name,
            'description' => $description,
            'icon' => $icon
        ]);
    }

    public function editCategory(int $id, string $name, string $description, string $icon)
    {
        $category = $this->getCategoryById($id);

        if (is_null($category)) {
            return [
                'errors' => 'Failed to retrieve Category',
                'http' => 404
            ];
        }

        $category->update([
            'name' => $name,
            'description' => $description,
            'icon' => $icon
        ]);
        return $category;
    }

    public function deleteCategory(int $id)
    {
        $category = $this->getCategoryById($id);

        if (is_null($category)) {
            return [
                'errors' => 'Category not found',
                'http' => 404
            ];
        }

        $category->delete();
        return ['success' => true];
    }
}