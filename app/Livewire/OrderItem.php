<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem as ModelsOrderItem;
use App\Models\Product;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Order-item')]
class OrderItem extends Component
{
    use WithPagination;

    #[Rule('required', as: 'order')]
    public $order_id;

    #[Rule('required', as: 'product')]
    public $product_id;

    #[Rule('required', 'numeric', 'min:0')]
    public $quantity;

    #[Rule('required', 'numeric', 'min:0')]
    public $subtotal;

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

        #[Url()]
        public $perPage = 5;

    #[Url(history: true)]
    public $search = '';

    public $editOrderItem;

    public function store()
    {
        $validated = $this->validate();
        ModelsOrderItem::create([
            'order_id' => $validated['order_id'],
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'subtotal' => $validated['subtotal'],
        ]);
        session()->flash('success', 'Order item created successfully');
        $this->reset();
    }

    public function delete(ModelsOrderItem $order)
    {
        $order->delete();
    }

    public function edit($editOrderItem)
    {
        $order = ModelsOrderItem::find($editOrderItem);
        if ($order) {
            $this->editOrderItem = $order->id;
            $this->order_id = $order->order_id;
            $this->product_id = $order->product_id;
            $this->quantity = $order->quantity;
            $this->subtotal = $order->subtotal;
        }
    }

    public function mount($editOrderItem = null)
    {
        if ($editOrderItem) {
            $this->edit($editOrderItem);
        }
    }

    public function update()
    {
        $validated = $this->validate();
        ModelsOrderItem::find($this->editOrderItem)->update($validated);
        session()->flash('success', 'Order item updated successfully');
        $this->reset();
    }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? "DESC" : "ASC";
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDir = 'ASC';
    }

    protected $listeners = ['calculateSubtotal'];

    public function calculateSubtotal()
    {
        $order = Order::find($this->order_id);
        if ($order) {
            $this->subtotal = $order->total_amount * $this->quantity;
        }
    }

    public function updatedOrder_id()
    {
        $this->calculateSubtotal();
    }

    public function updatedQuantity()
    {
        $this->calculateSubtotal();
    }

    public function render()
    {
        $orders = ModelsOrderItem::with('customer');
        $orderItems = ModelsOrderItem::with('product');
        return view('livewire.order-item', [
            'orders' => Order::all(),
            'products' => Product::all(),
            'orderItems' => ModelsOrderItem::where(function ($q) {
                if (!empty($this->search)) {
                    $q->where('quantity', 'like', '%' . $this->search . '%')
                        ->orWhere('subtotal', 'like', '%' . $this->search . '%')
                        ->orWhereHas('product', function ($q) {
                            $q->where('product_name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('order', function ($q) {
                            $q->where('total_amount', 'like', '%' . $this->search . '%');
                        });
                }
            })
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage)
        ]);
    }
}
