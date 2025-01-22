<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class Customers extends Component
{
    public $customers; 
    public $search ;

    public function mount()
    {
        $this->customers = Customer::all()->reverse();
    }
    public function delete($id)
    {
        $customer = Customer::find($id);
    
        if ($customer) {
            $customer->delete(); // Delete the customer
        }
    
        // Refresh the customers list
        $this->customers = Customer::all()->reverse();
    }

    public function updatedSearch()
    {
        $this->customers = Customer::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function viewAll() {

        $this->customers = Customer::all()->reverse();
    }

    public function forhim() {
        $this->customers = Customer::where('balance', '>', 0)->get();
    }
    public function onhim() {
        $this->customers = Customer::where('balance', '=<', 0)->get();
    }

    public function empty() {
        $this->customers = Customer::where('balance', '=', 0)->get();
    }
    public function render()
    {
        return view('livewire.customers.customers');
    }
}
