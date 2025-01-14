<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class EditProduct extends Component
{
    public $categories;
    public $product_id;
    public $product;

    public $name, $description,  $price1, $price2, $price3, $buying_price;
    public $itemStock,  $stockAlert, $category_id;

    public function mount()
    {
        $this->product_id = request()->segment(2);
        $this->categories = Category::all();
        $this->product = Product::find($this->product_id);

        $this->name = $this->product->name;
        $this->description = $this->product->description;
        $this->price1 = $this->product->price1;
        $this->price2 = $this->product->price2;
        $this->price3 = $this->product->price3;
        $this->buying_price = $this->product->buying_price;
        $this->itemStock = $this->product->itemStock;
        $this->stockAlert = $this->product->stockAlert;
        $this->category_id = $this->product->category_id;

    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price1' => 'nullable|numeric',
            'price2' => 'nullable|numeric',
            'price3' => 'nullable|numeric',
            'buying_price' => 'nullable|numeric',
            'itemStock' => 'nullable|integer',
            'stockAlert' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $this->product->update([
            'name' => $this->name,
            'description' => $this->description,
            'isActive' => true,
            'price1' => $this->price1,
            'price2' => $this->price2,
            'price3' => $this->price3,
            'buying_price' => $this->buying_price,
            'itemStock' => $this->itemStock,
            'stockAlert' => $this->stockAlert,
            'category_id' => $this->category_id,
        ]);

        session()->flash('message', 'تم التعديل بنجاح');
    }
    public function render()
    {
        return view('livewire.product.edit-product');
    }
}
