<?php

namespace App\Services;

use App\Models\OrderItems;
use Illuminate\Support\Facades\DB;

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
        $orderItem = OrderItems::create($data);

        $this->recalculateOrderTotal($orderItem->order_id);

        return $orderItem->load(['order', 'product']);
    }

    public function update(int $id, array $data)
{
    $orderItem = OrderItems::find($id);

    if (!$orderItem) {
        return null;
    }

    if (isset($data['product_id'])) {
        $product = \App\Models\Product::findOrFail($data['product_id']);
        $data['price'] = $product->price;
    }

    $orderItem->update($data);
    $this->recalculateOrderTotal($orderItem->order_id);

    return $orderItem->load(['order', 'product']);
}
    public function delete(int $id): bool
    {
        $orderItem = OrderItems::find($id);

        if (!$orderItem) {
            return false;
        }

        $orderId = $orderItem->order_id;

        $orderItem->delete();

        // update order total
        $this->recalculateOrderTotal($orderId);

        return true;
    }

    private function recalculateOrderTotal(int $orderId)
    {
        $total = OrderItems::where('order_id', $orderId)
            ->select(DB::raw('SUM(quantity * price) as total'))
            ->value('total');

        DB::table('orders')
            ->where('id', $orderId)
            ->update([
                'total_amount' => $total ?? 0
            ]);
    }
}