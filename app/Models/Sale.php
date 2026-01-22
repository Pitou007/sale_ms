<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {
    protected $fillable = [
      'user_id','customer_id','invoice_number','total_amount','discount','tax','final_total','payment_type'
    ];


    public function cashier()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class);
    }
    public function details()
    {
        return $this->hasMany(\App\Models\SaleDetail::class);
    }
}
