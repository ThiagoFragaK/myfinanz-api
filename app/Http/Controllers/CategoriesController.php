<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\CategoriesService;

class CategoriesController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new CategoriesService();
    }

    public function get(Request $request)
    {
        $categories = $this->service->getList($request->filters);
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $categories
        ], 200);
    }

    public function getCategoryById(int $id)
    {
        $category = $this->service->getCategoryById($id);
        return response()->json([
            'success' => true,
            'message' => 'Category retrieved successfully',
            'data' => $category
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->service->createCategory(
            $request->get("name"),
            $request->get("description"),
            $request->get("icon")
        );

        if (isset($response['errors'])) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Category',
                'errors' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $response
        ], 201);
    }

    public function edit(int $id, Request $request)
    {
        $response = $this->service->editCategory(
            $id,
            $request->get("name"),
            $request->get("description"),
            $request->get("icon")
        );

        if (isset($response['errors'])) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to edit Category',
                'errors' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $response
        ], 200);
    }

    public function delete(int $id)
    {
        $response = $this->service->deleteCategory($id);
        if (isset($response['errors'])) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Category',
                'errors' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
