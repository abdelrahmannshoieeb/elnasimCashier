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

    public function updatedSearch()
    {
        // dd($this->search);
        $searchTerm = trim($this->search);
    
        if (!empty($searchTerm)) {
            $this->customersBonds = CustomerBonnd::whereHas('customer', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%');
            })->get();
        } else {
            $this->customersBonds = collect(); // Return an empty collection when no search term is provided
        }
    }
    

    public function viewAll() {

        $this->customersBonds = CustomerBonnd::where('customer_id', $this->customer_id)->get();
    }




    public function filterBy($filter)
    {
        $this->updateTotals($filter);
    }
    
    public function bondfilterBy($filter)
    {
        $this->bondupdateTotals($filter);
    }
    
    private function bondupdateTotals($filter)
    {
        $dateFilter = match ($filter) {
            'day' => now()->startOfDay(),
            'week' => now()->subDays(now()->dayOfWeek - 1), // Week from today
            'month' => now()->subDays(now()->day - 1), // Month from today
            'year' => now()->subDays(now()->dayOfYear - 1)->startOfDay(), // Year from today
        default => now()->startOfDay(),// Default to today(),
        };

        $this->customersBonds = CustomerBonnd::where('created_at', '>=', $dateFilter)
        ->where('customer_id', $this->customer_id)
        ->get();
    }
    private function updateTotals($filter)
    {
        $dateFilter = match ($filter) {
            'day' => now()->startOfDay(),
            'week' => now()->subDays(now()->dayOfWeek - 1), // Week from today
            'month' => now()->subDays(now()->day - 1), // Month from today
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
