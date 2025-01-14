<?php

namespace App\Livewire\Customers;

use App\Models\CustomerBonnd;
use App\Models\Invoice;
use Egulias\EmailValidator\Result\Reason\UnclosedComment;

use Livewire\Component;

class CustomerDetails extends Component
{

    public $customersBonds; 
    public $search ;
    public $customer_id;


    public $invoices;


    
    
    public function mount()
    {
        $this->customer_id = request()->segment(2);
        $this->customersBonds = CustomerBonnd::where('customer_id', $this->customer_id)->get();
        $this->invoices = Invoice::where('customer_id', $this->customer_id)->get();
    }
    public function delete($id)
    {
        $user = CustomerBonnd::find($id);
        
        if ($user) {
            $user->delete();  // Delete the category
        }
    
        $this->customersBonds = CustomerBonnd::all();
    }

    public function thesearch()
    {
        $searchTerm = $this->search;
        $this->customersBonds = CustomerBonnd::whereHas('customer', function ($query) use ($searchTerm) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
            ;
        })->get();
       
    }

    public function viewAll() {

        $this->customersBonds = CustomerBonnd::where('customer_id', $this->customer_id)->get();
    }

    public function forhim() {
        $this->customersBonds = CustomerBonnd::where('type', 'add')
        ->where('customer_id', $this->customer_id)
        ->get();
    }
    public function onhim() {
        $this->customersBonds = CustomerBonnd::where('type', 'subtract')
        ->where('customer_id', $this->customer_id)
        ->get();
    }
    public function empty() {
        $this->customersBonds = CustomerBonnd::where('customer_id', $this->customer_id)->get();
    }
    public function cheque() {
        $this->customersBonds = CustomerBonnd::where('method', 'cheque')
        ->where('customer_id', $this->customer_id)
        
        ->get();
    }
    public function credit() {
        $this->customersBonds = CustomerBonnd::where('method', 'credit')
        ->where('customer_id', $this->customer_id)
        
        ->get();
    }
    public function cash() {
        $this->customersBonds = CustomerBonnd::where('method', 'cash')
        ->where('customer_id', $this->customer_id)
        
        ->get();
    }



    public function filterBy($filter)
    {
        $this->updateTotals($filter);
    }
    
    private function updateTotals($filter)
    {
        
     
      
        $dateFilter = match ($filter) {
            'day' => dd(now()->startOfDay()),
            'week' => dd(now()->subDays(now()->dayOfWeek - 1)), // Week from today
            'month' => dd(now()->subDays(now()->day - 1)), // Month from today
            'year' => now()->subDays(now()->dayOfYear - 1)->startOfDay(), // Year from today
        default => now()->startOfDay(),// Default to today(),
        };

        $this->invoices = Invoice::where('created_at', '>=', $dateFilter)
        ->where('customer_id', $this->customer_id)
        ->get();
    
       
    }
    public function render()
    {
        return view('livewire.customers.customer-details');
    }
}
