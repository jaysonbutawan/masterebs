<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index($id = null): JsonResponse
    {
        if ($id) {
            $item = $this->productService->getById($id);

            if (!$item) {
                return response()->json([
                    'message' => 'Product not found',
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'data' => $item,
            ]);
        }

        return response()->json([
            'message' => 'Products retrieved successfully',
            'data' => $this->productService->getAll(),
        ]);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $result = $this->productService->create($request->validated());

        return response()->json([
            'message' => $result['merged']
                ? 'Product already exists. Stock merged and price updated successfully.'
                : 'Product created successfully',
            'data' => $result['product'],
        ], $result['merged'] ? 200 : 201);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $result = $this->productService->update($id, $request->validated());

        if (!$result) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'message' => $result['merged']
                ? 'Product merged successfully with existing product.'
                : 'Product updated successfully',
            'data' => $result['product'],
        ]);
    }
    public function updateDetails(UpdateProductRequest $request, int $id)
    {
        $product = $this->productService->updateDetails($id, $request->validated());

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Product details updated successfully',
            'data' => $product
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->productService->delete($id);

        if (!$deleted) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }
}
