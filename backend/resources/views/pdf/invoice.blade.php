<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
        }

        .details {
            margin: 20px 0;
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice</h1>
        <p>Order #{{ $order->id }}</p>
        <p>Status: {{ $order->status }}</p>
        <p>Date: {{ $order->created_at->format('Y-m-d') }}</p>
    </div>

    <div class="details">
        <p>
            <strong>
                Customer:
            </strong>
            {{ $order->user->name }}
        </p>

        <section class="details">
            <h2>Order Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->productVariation->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->productVariation->price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p>
                <strong>
                    Tax:
                </strong>
                ${{ $order->tax }}
            </p>
            <p>
                <strong>
                    Shipping:
                </strong>
                ${{ $order->shipping }}
            </p>
            <p>
                <strong>
                    Total:
                </strong>
                ${{ $order->total }}
            </p>
        </section>
    </div>
</body>
</html>
