<?php

namespace App\Livewire;

use App\Models\Customer as ModelsCustomer;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Customer')]
class Customer extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:255')]
    public $first_name;

    #[Rule('required|min:3|max:255')]
    public $last_name;

    #[Rule('required|email|unique:customers,email')]
    public $email;

    #[Rule('required')]
    public $phone;

    #[Rule('required|min:3|max:255')]
    public $address;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 5;

    public $editCustomer;

    public function store()
    {
        $validated = $this->validate();

        ModelsCustomer::create($validated);

        session()->flash('success', 'Customer created successfully');
        $this->reset();
    }

    public function delete(ModelsCustomer $customer)
    {
        $customer->delete();
    }

    public function edit($editCustomer)
    {
        $customer = ModelsCustomer::find($editCustomer);
        if ($customer) {
            $this->editCustomer = $customer->id;
            $this->first_name = $customer->first_name;
            $this->last_name = $customer->last_name;
            $this->email = $customer->email;
            $this->phone = $customer->phone;
            $this->address = $customer->address;
        }
    }

    public function mount($editCustomer = null)
    {
        if ($editCustomer) {
            $this->edit($editCustomer);
        }
    }

    public function update()
    {
        ModelsCustomer::find($this->editCustomer)->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);
        session()->flash('success', 'Customer updated successfully');
        $this->reset();
    }

    public function setSortBy($sortByField)
    {
        $validColumns = ['first_name', 'last_name', 'email', 'created_at'];
        if (!in_array($sortByField, $validColumns)) {
            return;
        }
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? "DESC" : "ASC";
        } else {
            $this->sortBy = $sortByField;
            $this->sortDir = 'ASC';
        }
    }

    public function render()
    {
        return view('livewire.customer', [
            'customers' => ModelsCustomer::where(function ($query) {
                if (!empty($this->search)) {
                    $query->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                }
            })
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage)
        ]);
    }
}
