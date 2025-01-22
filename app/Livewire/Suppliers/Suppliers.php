<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Suppliers extends Component
{
    public $suppliers; 
    public $search ;

    public function mount()
    {
        $this->suppliers = Supplier::all()->reverse();
    }
    public function delete($id)
    {
        dd($id);
        $user = Supplier::find($id);
        
        if ($user) {
            $user->delete();  
        }
    
        $this->suppliers = Supplier::all()->reverse();
    }

    public function updatedSearch()
    {
        $this->suppliers = Supplier::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function viewAll() {

        $this->suppliers = Supplier::all()->reverse();
    }

    public function forhim() {
        $this->suppliers = Supplier::where('balance', '>', 0)->get();
    }
    public function onhim() {
        $this->suppliers = Supplier::where('balance', '<', 0)->get();
    }
    public function empty() {
        $this->suppliers = Supplier::where('balance', '=', 0)->get();
    }
    public function render()
    {
        return view('livewire.suppliers.suppliers');
    }
}
