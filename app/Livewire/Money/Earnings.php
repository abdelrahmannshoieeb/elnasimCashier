<?php

namespace App\Livewire\Money;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\SupplierInvoice;
use Egulias\EmailValidator\Result\Reason\UnclosedComment;
use Livewire\Component;

class Earnings extends Component
{
    public $earnings_from_customers = 0;
    public $receivable_to_suppliers = 0;
   

    public $Indebtedness_for_suppliers;


    public function mount()
    {
        $this->updateTotals('day'); // Default to day filter
    }

    public function filterBy($filter)
    {
        $this->updateTotals($filter);
    }

    private function updateTotals($filter)
    {
        // $dateFilter = match ($filter) {
        //     'day' => now()->startOfDay(),
        //     'week' => now()->startOfWeek(),
        //     'month' => now()->startOfMonth(),
        //     'year' => now()->startOfYear(),
        //     default => now()->startOfDay(),
        // };

        $this->earnings_from_customers = Customer::sum('balance');

        $this->receivable_to_suppliers = Supplier::sum('balance');
       
      
    }

    public function render()
    {
        return view('livewire.money.earnings');
    }
}
