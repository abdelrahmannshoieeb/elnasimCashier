<?php

namespace App\Livewire\Invoice;

use \Log;
use App\Models\Product;
use App\Models\settings;
use App\Models\Supplier;
use App\Models\SupplierInvoice;
use App\Models\SupplierInvoiceItem;
use Livewire\Component;

class SupplierAddInvoice extends Component
{

    public $bg;
    public $products = [];
    public $selectedProduct;
    public $priceOption = 'price1';
    public $selectedPrice = 0;
    public $search;
    public $searchSupplier;
    public $suppliers;
    public $selectedSupplierId;

    public $sell_price;
    public $items = [];
    public $newItem = [
        'name' => '',
        'quantity' => 1,
        'sell_price' => 0,
        'calculated_price' => 0,
    ];
    public $customerss = [
        [
            'name' => '',
            'balance' => '',
            'limit' => '', // Default sell_price option
        ]
    ];

    public $payMethod = 'cash';
    public $customerName = 'نقدي';  
    public $payedAmount = 0; //
    public $notes;       //
    public $discount = 0;  //
    public $status = 'unpaid';
    public $still = 0;
    public $total = 0;
    public $customerType = false; //
    public $supplier_id;  //

    public $showButtons = true;
    public $invoice;



    // refund
    public $showRefundSection = 0;
    public $showTotalMessage = 0;
    public $invoices;
    public $invoice_search;
    public $invoice_search_items;

    public function mount()
    {
        $this->showRefundSection = false;
        $this->showTotalMessage = false;

    }
    public function addItem()
    {
        
        if ($this->selectedProduct) {
            $requestedQuantity = $this->newItem['quantity'];
            $remainingQuantity = $requestedQuantity;
            $this->items[] = [
                'name' => $this->selectedProduct->name,
                'quantity' => $requestedQuantity, // Fulfilled quantity
                'calculated_price' => $this->sell_price, // Use sell_price
                'id' => $this->selectedProduct->id,
            ];
        }
    }




    public function updateQuantity($index, $quantity)
    {
        if (isset($this->items[$index])) {
            $this->items[$index]['quantity'] = $quantity;
        }
    }



    public function selectProduct($productId)
    {
        $this->selectedProduct = Product::with('stock')->find($productId); // Eager load stocks relationship

        if ($this->selectedProduct) {
            if ($this->selectedProduct->itemStock > 0) {
                $this->sell_price = $this->selectedProduct->price1; // Default to Price 1 for basic stock
            } else {
                // Default to the price of the first available stock
                $firstAvailableStock = $this->selectedProduct->stock->first();
                $this->sell_price = $firstAvailableStock ? $firstAvailableStock->price : null;
            }
        }
    }



    private function resetNewItem()
    {
        $this->newItem = [
            'name' => '',
            'priceOption' => '',
            'quantity' => 1,
            'sell_price' => 0,
            'calculated_price' => 0,
        ];
        $this->search = '';
    }
    public function selectedCustomer($supplierId)
    {
        $this->selectedSupplierId = $supplierId;

        $supplier = Supplier::find($supplierId);
        $this->searchSupplier = $supplier->name; // Update the search term to customer name
        $this->bg = " bg-green ";
    }



    public function updatedPriceOption()
    {
        $this->updateSelectedPrice();
    }


    private function updateSelectedPrice()
    {
        if ($this->selectedProduct) {
            $this->newItem['name'] = $this->selectedProduct->name;
            $this->newItem['calculated_price'] = $this->selectedProduct->{$this->priceOption};
        }
    }



    public function calctotal()
    {
        // Convert fields to proper types
        $this->total = is_numeric($this->total) ? (float) $this->total : 0.0;
        $this->payedAmount = is_numeric($this->payedAmount) ? (float) $this->payedAmount : 0.0;
        $this->discount = is_numeric($this->discount) ? (float) $this->discount : 0.0;
        // Calculate total
       
        $this->total = collect($this->items)->sum(function ($item) {
            return ($item['quantity'] * $item['calculated_price']) - (float) $this->discount;
        });
    }
    public function saveInvoice()
    {

        if (!$this->total) {
            $this->calctotal();
        }
        $this->validate([
            'items' => 'required|array|min:1',
        ]);

       
        // Set invoice status
        if ($this->payedAmount < $this->total && $this->payedAmount != 0) {
            $this->status = 'partiallyPaid';
            $this->still = $this->total - $this->payedAmount;
        } elseif ($this->payedAmount == $this->total) {
            $this->status = 'paid';
        } else {
            $this->status = 'unpaid';
            $this->still = $this->total;
        }


        // Save Invoice
        $invoice = SupplierInvoice::create([
            'total' => $this->total,
            'payedAmount' => $this->payedAmount,
            'notes' => $this->notes,
            'discount' => $this->discount,
            'status' => $this->status,
            'supplier_id' => $this->selectedSupplierId,
            'still' => $this->still,
        ]);

        $supplier = Supplier::find($this->selectedSupplierId);
        $supplier->balance = $supplier->balance + $this->still;
        $supplier->save();


        $this->invoice = $invoice;

        foreach ($this->items as $item) {
            SupplierInvoiceItem::create([
                'qty' => $item['quantity'],
                'buyingPrice' => $item['calculated_price'],
                'product_id' => $item['id'],
                'supplier_invoice_id' => $invoice->id,
            ]);
            $product = Product::find($item['id']);
            $product->itemStock += $item['quantity'];
            $product->save();
        }




        // Handle settings
        // $settings = settings::first();
        // if ($settings->adding_sellers_fund_to_box) {
        //     $settings->update([
        //         'box_value' => $settings->box_value + $this->payedAmount,
        //     ]);
        // }


        session()->flash('message', 'Invoice created successfully.');
        $this->showRefundSection = !$this->showRefundSection;
        $this->reset(['items', 'payMethod', 'payedAmount', 'notes', 'discount', 'status', 'supplier_id']);
    }


  
    public function updatedSearch()
    {
        $this->products = Product::where('name', 'like', '%' . $this->search . '%')->get();
    }
    public function updatedSearchSupplier()
    {
        $this->suppliers = Supplier::where('name', 'like', '%' . $this->searchSupplier . '%')->get();
    }



    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindex the array
    }


    public function toggleCustomerType()
    {
        if ($this->customerType === "attached") {
            $this->customerType = "unattached";
        } else {
            $this->customerType = "attached";
        }
    }

    public function continueInvoice($isContinue)
    {
        if ($isContinue) {
            $this->showButtons = true;
        } else {
            return redirect()->route('addInvoice');
        }
    }
    

    public function totalyPaid()
    {
        $this->calctotal();
        $this->payedAmount = $this->total;
        // dd($this->payedAmount);
    }

    public function render()
    {
        return view('livewire.invoice.supplier-add-invoice');
    }
}
