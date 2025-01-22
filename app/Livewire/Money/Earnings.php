<?php

namespace App\Livewire\Money;

use App\Models\Invoice;
use App\Models\SupplierInvoice;
use Egulias\EmailValidator\Result\Reason\UnclosedComment;
use Livewire\Component;

class Earnings extends Component
{
    public $earnings_from_totally_paid = 0;
    public $receivable_from_credit = 0;
    public $receivable_from_partiallypaid = 0;
    public $earnings_from_partiallypaid = 0;

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
        $dateFilter = match ($filter) {
            'day' => now()->startOfDay(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => now()->startOfDay(),
        };

        $this->earnings_from_totally_paid = Invoice::where('status', 'paid')
            ->where('created_at', '>=', $dateFilter)
            ->sum('total');

        $this->receivable_from_credit = Invoice::where('status', 'unpaid')
            ->where('created_at', '>=', $dateFilter)
            ->sum('total');
        $this->receivable_from_partiallypaid = Invoice::where('status', 'partiallyPaid')
            ->where('created_at', '>=', $dateFilter)
            ->sum('still');
        $this->earnings_from_partiallypaid = Invoice::where('status', 'partiallyPaid')
            ->where('created_at', '>=', $dateFilter)
            ->sum('total');
        $this->Indebtedness_for_suppliers = SupplierInvoice::whereIn('status', ['partiallyPaid', 'unpaid'])
            ->where('created_at', '>=', $dateFilter)
            ->sum('still');
    }

    public function render()
    {
        return view('livewire.money.earnings');
    }
}
