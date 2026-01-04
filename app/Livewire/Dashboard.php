<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $orders = [];

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        if (Auth::check()) {
            $this->orders = Auth::user()->orders()
                ->with('orderItems.product')
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
