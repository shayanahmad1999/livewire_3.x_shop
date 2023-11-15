<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Payment;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Payment edit')]
class PaymentEdit extends Component
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

    public function mount($id)
    {
        $payment = Payment::find($id);

        if ($payment) {
            $this->editPayment = $payment->id;
            $this->order_id = $payment->order_id;
            $this->payment_date = $payment->payment_date;
            $this->amount = $payment->amount;
            $this->payment_method = $payment->payment_method;
        }
    }

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
    
    public function update(){
        $validated = $this->validate();
        Payment::find($this->editPayment)->update($validated);
        return $this->redirect('/payment', navigate: true);
    }

    public function render()
    {
        $orders = Order::with('customer')->get();
        return view('livewire.payment-edit', [
            'orders' => $orders,
        ]);
    }
}
