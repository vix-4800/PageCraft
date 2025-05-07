<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        $limit = $request->input('limit', 10);

        return OrderResource::collection(
            Order::with('user')->orderBy('created_at', 'desc')->paginate($limit)
        );
    }

    /**
     * Display a listing of the latest orders.
     */
    public function latest(Request $request): JsonResource
    {
        $limit = $request->input('limit', 10);

        return OrderResource::collection(
            Order::with('user')->orderBy('created_at', 'desc')->take($limit)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $storeOrderRequest): JsonResource
    {
        /**
         * @var array{
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
         * } $validated
         */
        $validated = $storeOrderRequest->validated();

        return new OrderResource(
            $this->orderService->storeOrder($validated)->load(['items', 'user'])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResource
    {
        return new OrderResource(
            $order->load(['items.productVariation.product', 'items.productVariation.productVariationAttributes', 'user'])
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $updateOrderRequest, Order $order): JsonResource
    {
        $order->update($updateOrderRequest->validated());

        return new OrderResource(
            $order->load(['items.productVariation.product', 'user'])
        );
    }

    public function userOrders(Request $request): JsonResource
    {
        /** @var User $user */
        $user = $request->user();

        return OrderResource::collection(
            $user->orders()->orderBy('created_at', 'desc')->get()
        );
    }

    public function invoice(Order $order): StreamedResponse
    {
        $pdf = Pdf::loadView('pdf.invoice', compact('order'));

        return response()->streamDownload(
            fn (): int => print ($pdf->output()),
            'invoice.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }
}
