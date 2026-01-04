<div>
    <input type="number" wire:model="quantity" min="1" max="{{ $product->stock }}" class="border p-1 w-full rounded">
    <button wire:click="addToCart" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded hover:bg-blue-600">Add to Cart</button>
    @if (session('success'))        
        <div x-data="{ showFlash: true }" x-init="$nextTick(() => setTimeout(() => showFlash = false, 3000))" x-show="showFlash" 
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-3 shadow-lg transition-opacity">
            <span>{{ session('success') }}</span>            
        </div>
    @endif
    @if (session('error'))        
        <div x-data="{ showFlash: true }" x-init="$nextTick(() => setTimeout(() => showFlash = false, 3000))" x-show="showFlash" 
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-3 shadow-lg transition-opacity">
            <span>{{ session('error') }}</span>            
        </div>
    @endif
</div>