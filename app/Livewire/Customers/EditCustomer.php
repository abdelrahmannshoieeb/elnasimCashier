<?php

namespace App\Livewire\Customers;

use Livewire\Component;

class EditCustomer extends Component
{
    public $customer;

    public $name;
    public $notes;
    public $address;
    public $phone1;
    public $phone2;
    public $pocket_number;
    public $sell_price = 1;
    public $credit_limit;
    public $credit_limit_days;

    public function mount()
    {
        $customerid = request()->segment(2);
        $this->customer = \App\Models\Customer::find($customerid);

        $this->name = $this->customer->name;
        $this->notes = $this->customer->notes;
        $this->address = $this->customer->address;
        $this->phone1 = $this->customer->phone1;
        $this->phone2 = $this->customer->phone2;
        $this->pocket_number = $this->customer->pocket_number;
        $this->sell_price = $this->customer->sell_price;
        $this->credit_limit = $this->customer->credit_limit;
        $this->credit_limit_days = $this->customer->credit_limit_days;

    }
    
    
    
    public function save()
    {
        $this->customer->name = $this->name;
        $this->customer->notes = $this->notes;
        $this->customer->address = $this->address;
        $this->customer->phone1 = $this->phone1;
        $this->customer->phone2 = $this->phone2;
        $this->customer->pocket_number = $this->pocket_number;
        $this->customer->sell_price = $this->sell_price;
        $this->customer->credit_limit = $this->credit_limit;
        $this->customer->credit_limit_days = $this->credit_limit_days;
        $this->customer->save();
        session()->flash('message', 'تم تعديل العميل بنجاح');
    }
    public function render()
    {
        return view('livewire.customers.edit-customer');
    }
}
