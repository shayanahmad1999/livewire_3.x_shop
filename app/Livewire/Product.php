<?php

namespace App\Livewire;

use App\Models\Product as ModelsProduct;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Product')]
class Product extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:255')]
    public $product_name;

    #[Rule('required|min:3|max:255')]
    public $description;
    
    #[Rule('required')]
    public $price;

    #[Rule('required')]
    public $stock_quantity;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 5;

    public $editProduct;

    public function store() {
        $validated = $this->validate();
        ModelsProduct::create($validated);
        session()->flash('success', 'Product created successfully');
        $this->reset();
       $this->dispatch('close-modal');
    }

    public function delete(ModelsProduct $product) {
        $product->delete();
    }

    public function edit($editProduct)
    {
        $product = ModelsProduct::find($editProduct);
        if ($product) {
            $this->editProduct = $product->id;
            $this->product_name = $product->product_name;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->stock_quantity = $product->stock_quantity;
            // $this->dispatch('open-modal', ['name' => 'add']);
        }
    }

    public function mount($editProduct = null)
    {
        if ($editProduct) {
            $this->edit($editProduct);
        }
    }

    public function update() {
        $validated = $this->validate();
        ModelsProduct::find($this->editProduct)->update([
            'product_name' => $validated['product_name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
        ]);
        session()->flash('success', 'Product updated successfully');
        $this->reset();
        $this->dispatch('close-modal');
    }

    public function setSortBy($sortByField)
    {
        if($this->sortBy === $sortByField){
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }
            $this->sortBy = $sortByField;
            $this->sortDir = 'ASC';
    }
    
    public function render()
    {
        return view('livewire.product', [
            'products' => ModelsProduct::where(function ($query) {
                if (!empty($this->search)) {
                    $query->where('product_name', 'like', '%' . $this->search . '%')
                        ->orWhere('price', 'like', '%' . $this->search . '%')
                        ->orWhere('stock_quantity', 'like', '%' . $this->search . '%');
                }
            })
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage)
        ]);
    }
}
