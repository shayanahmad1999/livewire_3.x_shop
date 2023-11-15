<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order as ModelsOrder;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Order')]
class Order extends Component
{
    use WithPagination;

    #[Rule('required', as: 'customer name')]
    public $customer_id;

    #[Rule('required', 'date')]
    public $order_date;

    #[Rule('required', 'numeric', 'min:0', 'max:18446744073709551615')]
    public $total_amount;

    #[Url(history: true)]
    public $sortBy = 'order_date';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 5;

    #[Url(history: true)]
    public $search = '';

    public $editOrder;

    public function store(){
        $validated = $this->validate();
        ModelsOrder::create([
            'customer_id' => $validated['customer_id'],
            'order_date' => $validated['order_date'],
            'total_amount' => $validated['total_amount'],
        ]);
        session()->flash('success', 'Order created successfully');
        $this->reset();
    }

    public function delete(ModelsOrder $order) {
        $order->delete();
    }

    public function edit($editOrder) {
        $order = ModelsOrder::find($editOrder);
        if($order) {
            $this->editOrder = $order->id;
            $this->customer_id = $order->customer_id;
            $this->order_date = $order->order_date;
            $this->total_amount = $order->total_amount;
        }
    }

    public function mount($editOrder = null) {
        if ($editOrder) {
            $this->edit($editOrder);
        }
    } 

    public function update() {
        $validated = $this->validate();
        ModelsOrder::find($this->editOrder)->update($validated);
        session()->flash('success', 'Order updated successfully');
        $this->reset();
    }

    public function setSortBy($sortByField) {
        if($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? "DESC" : "ASC";
            return;
        }
            $this->sortBy = $sortByField;
            $this->sortDir = 'ASC';
    }

    public function render()
    {
        $orders = ModelsOrder::with('customer');
        return view('livewire.order', [
            'customers' => Customer::all(),
            'orders' => ModelsOrder::where(function ($q) {
                if(!empty($this->search)) {
                    $q->where('order_date', 'like', '%' . $this->search . '%')
                    ->orWhere('total_amount', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($q) {
                        $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
                }
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage)
        ]);
    }
}
