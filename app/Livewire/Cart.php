<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Jobs\LowStockJob;

class Cart extends Component
{
    public $cartItems = [];
    public $total = 0;
    public $quantities = [];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        if (Auth::check()) {
            $this->cartItems = Auth::user()->cartItems()->with('product')->get();
            $this->total = $this->cartItems->sum(fn($item) => $item->quantity * $item->product->price);
            
            $this->quantities = [];
            foreach ($this->cartItems as $item) {
                $this->quantities[$item->id] = $item->quantity;
            }
        }
    }

    public function updateQuantity($id)
    {
        $qty = (int) ($this->quantities[$id] ?? 1);

        if ($qty <= 0) {
            $this->removeItem($id);
            return;
        }

        $item = CartItem::findOrFail($id);
        $availableStock = $item->product->stock;

        if ($qty > $availableStock) {
            session()->flash('error', "Cannot exceed stock: {$availableStock} available.");
            $this->quantities[$id] = $item->quantity;
            return;
        }

        $item->update(['quantity' => $qty]);
        $this->loadCart();
        session()->flash('success', 'Quantity updated!');
    }

    public function removeItem($id)
    {
        CartItem::findOrFail($id)->delete();
        session()->flash('success', 'Item removed!');
        $this->loadCart();
    }

    public function checkout()
    {
        if ($this->cartItems->isEmpty()) return;

        // Create order
        $order = Auth::user()->orders()->create(['total' => $this->total]);

        // Process items
        foreach ($this->cartItems as $cartItem) {
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);

            // Deduct stock
            $cartItem->product->decrement('stock', $cartItem->quantity);

            // Check low stock
            if ($cartItem->product->stock < 5) {
                LowStockJob::dispatch($cartItem->product);
            }
        }

        // Clear cart
        Auth::user()->cartItems()->delete();
        $this->quantities = []; // Clear temps

        session()->flash('success', 'Order placed! Total: $' . $this->total);
        $this->loadCart();

        return redirect()->route('dashboard');
    }

    protected $listeners = ['cart-updated' => 'loadCart'];

    public function render()
    {
        return view('livewire.cart');
    }
}
