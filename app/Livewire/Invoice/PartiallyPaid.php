<?php


namespace App\Livewire\Invoice;

use App\Models\Invoice;
use Livewire\Component;

class PartiallyPaid extends Component
{

    public $partiallyPaid_invoices;
    public $customerName;
    public $invoiceId;

    public function mount()
    {
        $this->partiallyPaid_invoices = Invoice::where('status', 'partiallyPaid')->get();
      
    }

    public function updatedCustomerName()
    
    {
        if ($this->customerName) {
            $this->partiallyPaid_invoices = Invoice::where('status', 'partiallyPaid')
            ->whereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . $this->customerName . '%');
            })->get();
        }
        else {
            $this->partiallyPaid_invoices = Invoice::where('status', 'partiallyPaid')->get();
        }
    }

    public function updatedInvoiceId() {
        if ($this->invoiceId) {
            $this->partiallyPaid_invoices = Invoice::where('id', $this->invoiceId)
            ->where('status', 'partiallyPaid')
            ->get();
        }
        else
        {
            $this->partiallyPaid_invoices = Invoice::where('status', 'partiallyPaid')->get();
        }
    }
    

    public function viewAll(){

        $this->partiallyPaid_invoices = Invoice::where('status', 'partiallyPaid')->get();
    }

    public function delete($id) {
        $invoice = Invoice::find($id);
        $invoice->delete();
        $this->partiallyPaid_invoices = Invoice::where('status', 'partiallyPaid')->get();
    }
    public function render()
    {
        return view('livewire.invoice.partially-paid');
    }
}
