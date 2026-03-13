<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}

    public function index(?int $id = null): JsonResponse
    {
        if ($id) {
            $category = $this->categoryService->getById($id);

            if (! $category) {
                return response()->json(['message' => 'Category not found'], 404);
            }

            return response()->json($category);
        }

        return response()->json(
            $this->categoryService->getAll()
        );
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($this->categoryService->existsByName($data['name'])) {
            return response()->json([
                'message' => 'This category already exists.',
            ], 422);
        }

        try {
            $category = $this->categoryService->create($data);
        } catch (QueryException $exception) {
            $errorCode = $exception->errorInfo[1] ?? null;

            if ($errorCode === 1062) {
                return response()->json([
                    'message' => 'This category already exists.',
                ], 422);
            }

            throw $exception;
        }

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = $this->categoryService->update(
            $id,
            $request->validated()
        );

        if (! $category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->categoryService->delete($id);

        if (! $deleted) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }
}
