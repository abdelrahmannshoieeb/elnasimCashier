<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer_bonds()
    {
        return $this->hasMany(CustomerBonnd::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}