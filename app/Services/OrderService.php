<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class OrderService
{
    public function getAll()
    {
        return Order::with(['user', 'items.product'])->get();
    }

    public function getById(int $id)
    {
        return Order::with(['user', 'items.product'])->find($id);
    }

public function createOrder(int $userId, array $items)
{
    return DB::transaction(function () use ($userId, $items) {

        $totalAmount = 0;
        $orderItems = [];

        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']); 
            $price = $product->price;

            $totalAmount += $price * $item['quantity'];

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $price,
            ];
        }

        $order = Order::create([
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'status' => Order::STATUS_PENDING,
        ]);

        foreach ($orderItems as $orderItem) {
            $order->items()->create($orderItem);
        }

        return $order->load(['user', 'items.product']);
    });
}

    public function updateOrder(int $id, array $data)
    {
        $order = Order::find($id);

        if (!$order) {
            return null;
        }

        $order->update($data);

        return $order->load(['user', 'items.product']);
    }

    public function cancelOrder(int $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return [
                'status' => false,
                'message' => 'Order not found',
                'data' => null,
            ];
        }

        if ($order->status === Order::STATUS_CANCELLED) {
            return [
                'status' => false,
                'message' => 'Order is already cancelled',
                'data' => null,
            ];
        }

        if ($order->status === Order::STATUS_COMPLETED) {
            return [
                'status' => false,
                'message' => 'Completed orders cannot be cancelled',
                'data' => null,
            ];
        }

        $order->update([
            'status' => Order::STATUS_CANCELLED,
        ]);

        return [
            'status' => true,
            'message' => 'Order cancelled successfully',
            'data' => $order->load(['user', 'items.product']),
        ];
    }
}