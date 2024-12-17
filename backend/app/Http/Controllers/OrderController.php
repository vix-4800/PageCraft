<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Str;

class OrderController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['store']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        $query = Order::orderBy('created_at', 'desc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }

        return OrderResource::collection($query->get()->load('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): JsonResource
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            /** @var User $user */
            $user = User::firstOrCreate(
                ['email' => $validated['details']['email']],
                [
                    'name' => $validated['details']['name'],
                    'phone' => $validated['details']['phone'],
                    'password' => bcrypt(Str::random(16)),
                ],
            );

            /** @var Order $order */
            $order = $user->orders()->create(['total' => $validated['total']]);

            $products = collect($validated['products']);

            $products->each(function (array $product) use ($order): void {
                /** @var ProductVariation $productVariation */
                $productVariation = ProductVariation::firstWhere('sku', $product['product']['sku']);

                $order->items()->create([
                    'quantity' => $product['quantity'],
                    'product_variation_id' => $productVariation->id,
                ]);

                $productVariation->decrement('stock', $product['quantity']);
            });

            DB::commit();

            return OrderResource::make($order->load(['items', 'user']));
        } catch (\Throwable $th) {
            DB::rollBack();

            throw new ApiException;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
