<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->query('from');
        $to   = $request->query('to');

        $sales = Sale::with(['cashier','customer'])
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to,   fn($q) => $q->whereDate('created_at', '<=', $to))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalFinal = (clone $sales->getCollection())->sum('final_total'); // page total

        return view('admin.reports.sales', compact('sales','from','to','totalFinal'));
    }

    public function stock(Request $request)
    {
        $q = $request->query('q');

        $items = Product::with(['category','supplier'])
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('barcode', 'like', "%{$q}%");
            })
            ->orderBy('qty')
            ->paginate(15)
            ->withQueryString();

        return view('admin.reports.stock', compact('items','q'));
    }

    public function transactions(Request $request)
    {
        $type = $request->query('type');
        $from = $request->query('from');
        $to   = $request->query('to');

        $items = StockTransaction::with(['product','user','supplier'])
            ->when($type, fn($q) => $q->where('type', $type))
            ->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to,   fn($q) => $q->whereDate('date', '<=', $to))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.reports.transactions', compact('items','type','from','to'));
    }
}
