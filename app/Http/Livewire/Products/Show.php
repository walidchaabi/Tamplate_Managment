<?php

declare(strict_types=1);

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class Show extends Component
{
    public $product;

    public $listeners = [
        'showModal',
    ];

    public $showModal = false;

    public function showModal($id)
    {
        abort_if(Gate::denies('product_show'), 403);

        $this->product = Product::findOrFail($id);

        $this->showModal = true;
    }

    public function render(): View|Factory
    {
        return view('livewire.products.show');
    }
}
