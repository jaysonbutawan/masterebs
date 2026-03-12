<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index($id = null): JsonResponse
    {
        if ($id) {
            $order = $this->orderService->getById($id);

            if (!$order) {
                return response()->json([
                    'message' => 'Order not found',
                ], 404);
            }

            return response()->json([
                'message' => 'Order retrieved successfully',
                'data' => $order,
            ]);
        }

        $orders = $this->orderService->getAll();

        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => $orders,
        ]);
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $order = $this->orderService->createOrder(
            $validated['user_id'],
            $validated['items']
        );

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order,
        ], 201);
    }

    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {
        $order = $this->orderService->updateOrder($id, $request->validated());

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $order,
        ]);
    }

    public function cancel(int $id): JsonResponse
    {
        $result = $this->orderService->cancelOrder($id);

        if (!$result['status']) {
            return response()->json([
                'message' => $result['message'],
            ], 400);
        }

        return response()->json([
            'message' => $result['message'],
            'data' => $result['data'],
        ]);
    }
}
