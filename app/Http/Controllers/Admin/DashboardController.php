<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use App\Models\StockTransaction;


class DashboardController extends Controller {
    public function index(){
        $today = now()->toDateString();


        $todaySales = Sale::whereDate('created_at', $today)->sum('final_total');
        $todayInvoices = Sale::whereDate('created_at', $today)->count();
        $lowStock = Product::where('qty','<=', 5)->orderBy('qty')->limit(10)->get();
        $latestTransactions = StockTransaction::latest()->limit(10)->get();


    return view('admin.dashboard', compact('todaySales','todayInvoices','lowStock','latestTransactions'));
    }
}
