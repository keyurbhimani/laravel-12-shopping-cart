<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartAdd extends Component
{
    public $product;
    public $quantity = 1;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart()
    {        
        if (!Auth::check()) {
            session()->flash('error', 'Please login first.');
            return;
        }

        $existing = CartItem::where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->first();

        $newQty = $this->quantity;
        if ($existing) {
            $newQty += $existing->quantity;
        }

        if ($newQty > $this->product->stock) {
            session()->flash('error', "Cannot add: Only {$this->product->stock} left in stock.");
            return;
        }

        CartItem::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $this->product->id],
            ['quantity' => $newQty]
        );

        session()->flash('success', 'Added to cart!');
        $this->dispatch('cart-updated');        
    }

    public function render()
    {
        return view('livewire.cart-add');
    }
}
