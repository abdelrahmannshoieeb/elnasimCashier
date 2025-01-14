<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];


     public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function supplier_invoice_items()
    {
        return $this->hasMany(SupplierInvoiceItem::class);
    }
}
