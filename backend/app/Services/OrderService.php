<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Str;
use Throwable;

final class OrderService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param array{
     *      details: array{
     *          name: string,
     *          email: string,
     *          phone: string
     *      },
     *      products: array<array{
     *          quantity: int,
     *          sku: string
     *      }>,
     *      tax: float,
     *      shipping: float,
     *      note: string|null
     * } $orderData
     *
     * @throws Throwable
     */
    public function storeOrder(array $orderData): Order
    {
        try {
            DB::beginTransaction();

            /** @var User $user */
            $user = User::firstOrCreate(
                ['email' => $orderData['details']['email']],
                [
                    'name' => $orderData['details']['name'],
                    'phone' => $orderData['details']['phone'],
                    'password' => bcrypt(Str::random(16)),
                    'role_id' => Role::firstWhere('name', UserRole::CUSTOMER)->id,
                ],
            );

            $products = collect($orderData['products']);
            $subTotal = $products->sum(fn (array $product): float => $product['quantity'] * ProductVariation::firstWhere('sku', $product['sku'])->price);

            /** @var Order $order */
            $order = $user->orders()->create([
                'sub_total' => $subTotal,
                'tax' => $orderData['tax'],
                'shipping' => $orderData['shipping'],
                'total' => $subTotal + $orderData['shipping'] + $orderData['tax'],
                'note' => $orderData['note'],
            ]);

            $products->each(function (array $product) use ($order): void {
                /** @var ProductVariation $productVariation */
                $productVariation = ProductVariation::firstWhere('sku', $product['sku']);

                $order->items()->create([
                    'quantity' => $product['quantity'],
                    'product_variation_id' => $productVariation->id,
                ]);

                $productVariation->decrement('stock', $product['quantity']);
            });

            DB::commit();

            return $order;
        } catch (Throwable $throwable) {
            DB::rollBack();

            throw $throwable;
        }
    }
}
