<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Your Orders</h1>

    @if($orders->isEmpty())
        <p class="text-gray-500">No orders yet. <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">Start shopping!</a></p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2 text-left">Order ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Date</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Total</th>                        
                        <th class="border border-gray-300 px-4 py-2 text-left">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2 font-medium">#{{ $order->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="border border-gray-300 px-4 py-2 font-bold">${{ number_format($order->total, 2) }}</td>                            
                            <td class="border border-gray-300 px-4 py-2">
                                <details class="cursor-pointer">
                                    <summary class="text-blue-500 hover:underline">View Items ({{ $order->orderItems->count() }})</summary>
                                    <div class="mt-2 p-2 bg-gray-50 border border-gray-200">
                                        @foreach($order->orderItems as $item)
                                            <div class="flex justify-between items-center py-1 text-sm">
                                                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                                <span>@ {{ $item->price }} = ${{ number_format($item->quantity * $item->price, 2) }}</span>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 pt-2 border-t border-gray-300 text-right font-bold">
                                            Order Total: ${{ number_format($order->total, 2) }}
                                        </div>
                                    </div>
                                </details>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>