<div class="p-4">    
    @if (session()->has('success'))
        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif
    <h2 class="text-2xl font-bold mb-4 mt-4">Shopping Cart</h2>
    @if($cartItems->isEmpty())
        <p class="text-gray-500">Cart is empty.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2 text-left">Product</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Qty</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Price</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Total</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $item->product->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input 
                                    type="number" 
                                    wire:model.debounce.500ms="quantities.{{ $item->id }}" 
                                    min="1" 
                                    max="{{ $item->product->stock }}" 
                                    class="border border-gray-300 p-1 w-16 rounded" 
                                    value="{{ $this->quantities[$item->id] ?? $item->quantity }}"
                                >
                                <button 
                                    wire:click="updateQuantity({{ $item->id }})" 
                                    class="bg-green-500 text-white px-3 py-1 rounded ml-2 text-sm hover:bg-green-600"
                                >
                                    Update
                                </button>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">${{ number_format($item->product->price, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2 font-medium">${{ number_format($item->quantity * $item->product->price, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <button 
                                    wire:click="removeItem({{ $item->id }})" 
                                    class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600"
                                >
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-between items-center">
            <p class="font-bold text-lg">Grand Total: ${{ number_format($total, 2) }}</p>
            <button 
                wire:click="checkout" 
                class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600"
                {{ $cartItems->isEmpty() ? 'disabled' : '' }}
            >
                Checkout
            </button>
        </div>
    @endif    
</div>