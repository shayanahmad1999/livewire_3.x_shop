<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Payment;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Payment create')]
class PaymentForm extends Component
{
    #[Rule('required', as: 'order')]
    public $order_id;

    #[Rule('required|date')]
    public $payment_date;

    #[Rule('required', 'numeric', 'min:0')]
    public $amount;

    #[Rule('required', 'min:3', 'max:255')]
    public $payment_method;

    public $editPayment;

    protected $listeners = ['calculateSubtotal'];

    public function calculateSubtotal()
    {
        $order = Order::find($this->order_id);
        if ($order) {
            $this->amount = $order->total_amount;
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

    public function store() {
        $validated = $this->validate();
        Payment::create($validated);
        session()->flash('success', 'Payment add successfully');
        $this->reset();
        $this->dispatch('form-created', $validated);
    }

    public function render()
    {
        $orders = Order::with('customer');
        return view('livewire.payment-form', [
            'orders' => Order::all()
        ]);
    }
}
