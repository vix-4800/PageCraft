<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth:sanctum', 'admin'], except: ['store']),
        ];
    }

    public function __construct(
        private readonly OrderService $service
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
    public function store(StoreOrderRequest $request): JsonResource
    {
        $validated = $request->validated();

        return new OrderResource(
            $this->service->storeOrder($validated)->load(['items', 'user'])
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
    public function update(UpdateOrderRequest $request, Order $order): JsonResource
    {
        $order->update($request->validated());

        return new OrderResource(
            $order->load(['items.productVariation.product', 'user'])
        );
    }

    public function userOrders(Request $request): JsonResource
    {
        /** @var \App\Models\User $user */
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
