<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderItemsRequest;
use App\Http\Requests\UpdateOrderItemsRequest;
use App\Services\OrderItemsService;
use Illuminate\Http\JsonResponse;

class OrderItemsController extends Controller
{
    protected OrderItemsService $orderItemsService;

    public function __construct(OrderItemsService $orderItemsService)
    {
        $this->orderItemsService = $orderItemsService;
    }

    public function index(): JsonResponse
    {
        $orderItems = $this->orderItemsService->getAll();

        return response()->json([
            'message' => 'Order items retrieved successfully',
            'data' => $orderItems
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $orderItem = $this->orderItemsService->getById($id);

        if (!$orderItem) {
            return response()->json([
                'message' => 'Order item not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Order item retrieved successfully',
            'data' => $orderItem
        ]);
    }

    public function store(StoreOrderItemsRequest $request): JsonResponse
    {
        $orderItem = $this->orderItemsService->create($request->validated());

        return response()->json([
            'message' => 'Order item created successfully',
            'data' => $orderItem
        ], 201);
    }

    public function update(UpdateOrderItemsRequest $request, int $id): JsonResponse
    {
        $orderItem = $this->orderItemsService->update($id, $request->validated());

        if (!$orderItem) {
            return response()->json([
                'message' => 'Order item not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Order item updated successfully',
            'data' => $orderItem
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->orderItemsService->delete($id);

        if (!$deleted) {
            return response()->json([
                'message' => 'Order item not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Order item deleted successfully'
        ]);
    }
}
