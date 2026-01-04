<div>
    <!-- Search Box -->
    <div class="p-4 flex justify-between items-center">        
        <input
            type="text"
            wire:model.live.debounce.500ms="search"
            placeholder="Search products..."
            class="w-full md:w-1/3 border rounded px-3 py-2"
        />
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
        @forelse($products as $product)
            <div class="border p-4 rounded bg-white" wire:key="product-{{ $product->id }}">
                <h3 class="font-bold">{{ $product->name }}</h3>
                <p>${{ number_format($product->price, 2) }}</p>
                <p class="text-sm text-gray-600">Stock: {{ $product->stock }}</p>

                <livewire:cart-add 
                    :product="$product"
                    :key="'cart-add-'.$product->id"
                />
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-500">
                No products found.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="p-4">
        {{ $products->links() }}
    </div>
</div>
