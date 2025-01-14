<?php

namespace App\Livewire\Suppliers;

use Livewire\Component;

class EditSupplier extends Component
{
    public $supplier;   

    public $name;
    public $notes;
    public $address;
    public $phone;


    public function mount ()
    {
        $supplierid = request()->segment(2);
        $this->supplier = \App\Models\Supplier::find($supplierid);

        $this->name = $this->supplier->name;    
        $this->notes = $this->supplier->notes;
        $this->address = $this->supplier->address;
        $this->phone = $this->supplier->phone;
    }

    public function save() {

        $this->supplier->name = $this->name;
        $this->supplier->notes = $this->notes;
        $this->supplier->address = $this->address;
        $this->supplier->phone = $this->phone;
        $this->supplier->save();

        session()->flash('message', 'تم تعديل المورد بنجاح');
        
    }
    public function render()
    {
        return view('livewire.suppliers.edit-supplier');
    }
}
