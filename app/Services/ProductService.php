<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAll()
    {
        return Product::where('status', 1)->with('category')->get();
    }

    public function getById(int $id)
    {
        return Product::where('status', 1)->with('category')->find($id);
    }

    public function create(array $data)
    {
        $existingProduct = Product::whereRaw('LOWER(name) = ?', [strtolower($data['name'])])
            ->where('category_id', $data['category_id'])
            ->first();

        if ($existingProduct) {
            $existingProduct->update([
                'stock' => $existingProduct->stock + $data['stock'],
                'price' => $data['price'],
                'description' => $data['description'] ?? $existingProduct->description,
            ]);

            return [
                'merged' => true,
                'product' => $existingProduct->fresh('category'),
            ];
        }

        $product = Product::create($data);

        return [
            'merged' => false,
            'product' => $product->load('category'),
        ];
    }

    public function update(int $id, array $data)
    {
        $product = Product::where('status', 1)->find($id);

        if (!$product) {
            return null;
        }

        if (isset($data['name'])) {
            $duplicateProduct = Product::whereRaw('LOWER(name) = ?', [strtolower($data['name'])])
                ->where('category_id', $data['category_id'] ?? $product->category_id)
                ->where('id', '!=', $id)
                ->first();

            if ($duplicateProduct) {
                $duplicateProduct->update([
                    'stock' => $duplicateProduct->stock + ($data['stock'] ?? $product->stock),
                    'price' => $data['price'] ?? $duplicateProduct->price,
                    'description' => $data['description'] ?? $duplicateProduct->description,
                ]);

                $product->delete();

                return [
                    'merged' => true,
                    'product' => $duplicateProduct->fresh('category'),
                ];
            }
        }

        $product->update($data);

        return [
            'merged' => false,
            'product' => $product->fresh('category'),
        ];
    }

    public function delete(int $id): bool
    {
        $product = Product::find($id);

        if (!$product) {
            return false;
        }

        return  $product->update([
            'status' => 0
        ]);
    }
}