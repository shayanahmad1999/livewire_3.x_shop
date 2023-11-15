<?php

namespace App\Livewire;

use App\Models\Order as ModelsOrder;
use App\Models\Payment as ModelsPayment;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Payment')]
class Payment extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 5;

    public function delete(ModelsPayment $payment){
        $payment->delete();
    }
    

    public function setSortBy($sortByField) {
        if($this->sortBy === $sortByField){
            $this->sortDir = ($this->sortDir == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDir = 'ASC';
    } 

    #[On('form-created')]
    public function render()
    {
        $payments = ModelsPayment::with('order'); 
        $orders = ModelsOrder::with('customer');
        return view('livewire.payment', [
            'payments' => ModelsPayment::where(function($q) { 
                if(!empty($this->search)) {
                    $q->where('payment_date', 'like', '%' . $this->search . '%')
                    ->orWhere('amount', 'like', '%' . $this->search . '%')
                    ->orWhere('payment_method', 'like', '%' . $this->search . '%')
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
