<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = [
    'category_id','supplier_id','name','barcode','cost_price','sale_price','qty','image'
    ];


    public function category(){ return $this->belongsTo(Category::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function promotions(){ return $this->belongsToMany(Promotion::class); }
    public function saleDetails(){ return $this->hasMany(SaleDetail::class); }
    public function stockTransactions(){ return $this->hasMany(StockTransaction::class); }


    public function activePromotions(){
        return $this->promotions()
        ->where('is_active', true)
        ->whereDate('start_date','<=', now())
        ->whereDate('end_date','>=', now());
    }
    
}
