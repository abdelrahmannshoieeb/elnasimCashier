<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class CashierName extends Component
{

    public $name;
    public $password;
    public $admin;


    public function mount(){
        $this->admin = User::where('role', 'admin')->first();

        $this->name = $this->admin->name;
        
    }

    public function save(){
        $this->admin->update([
            'name' => $this->name,
            'password' => bcrypt($this->password),
        ]);

        session()->flash('success', 'تم تغيير بيانات التسجيل بنجاح');
    }
    public function render()
    {
        return view('livewire.admin.cashier-name');
    }
}
