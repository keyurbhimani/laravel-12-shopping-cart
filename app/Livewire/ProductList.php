<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Product;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public string $search = '';

    public function updatingSearch()
    {        
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.product-list', [
            'products' => Product::query()
                ->where('stock', '>', 0)
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name')
                ->paginate(5),
        ]);
    }
}
