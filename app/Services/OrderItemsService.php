<?php

namespace App\Services;

use App\Models\OrderItems;

class OrderItemsService
{
    public function getAll()
    {
        return OrderItems::with(['order', 'product'])->get();
    }

    public function getById(int $id)
    {
        return OrderItems::with(['order', 'product'])->find($id);
    }

    public function create(array $data)
    {
        return OrderItems::create($data);
    }

    public function update(int $id, array $data)
    {
        $orderItem = OrderItems::find($id);

        if (!$orderItem) {
            return null;
        }

        $orderItem->update($data);

        return $orderItem->load(['order', 'product']);
    }

    public function delete(int $id): bool
    {
        $orderItem = OrderItems::find($id);

        if (!$orderItem) {
            return false;
        }

        return (bool) $orderItem->delete();
    }
}