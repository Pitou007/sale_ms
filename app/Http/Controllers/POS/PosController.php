<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        // Load products for POS UI (JS cart)
        $products = Product::select('id', 'name', 'barcode', 'sale_price', 'qty')
            ->orderBy('name')
            ->get();

        return view('pos.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'exists:customers,id'],
            'payment_type' => ['required', 'in:cash,qr,card'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
        ]);

        return DB::transaction(function () use ($data, $request) {

            // 1) Validate stock (lock rows)
            foreach ($data['items'] as $it) {
                $p = Product::lockForUpdate()->findOrFail($it['product_id']);
                if ($p->qty < $it['qty']) {
                    abort(422, "Not enough stock for {$p->name}");
                }
            }

            // 2) Calculate totals
            $subtotal = 0;
            foreach ($data['items'] as $it) {
                $subtotal += ($it['qty'] * $it['price']);
            }

            $discount = (float)($data['discount'] ?? 0);
            $tax = (float)($data['tax'] ?? 0);
            $final = max(0, $subtotal - $discount + $tax);

            // 3) Create sale
            $sale = Sale::create([
                'user_id' => $request->user()->id,
                'customer_id' => $data['customer_id'] ?? null,
                'invoice_number' => $this->nextInvoiceNumber(),
                'total_amount' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'final_total' => $final,
                'payment_type' => $data['payment_type'],
            ]);

            // 4) Create details + stock updates + transactions
            foreach ($data['items'] as $it) {
                $p = Product::lockForUpdate()->findOrFail($it['product_id']);

                $lineSubtotal = $it['qty'] * $it['price'];

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $p->id,
                    'qty' => $it['qty'],
                    'price' => $it['price'],
                    'subtotal' => $lineSubtotal,
                ]);

                $p->decrement('qty', $it['qty']);

                StockTransaction::create([
                    'product_id' => $p->id,
                    'user_id' => $request->user()->id,
                    'supplier_id' => null,
                    'type' => 'sale',
                    'qty' => $it['qty'],
                    'date' => now()->toDateString(),
                    'note' => "Sale {$sale->invoice_number}",
                ]);
            }

            return redirect()->route('admin.pos.sales.show', $sale);
        });
    }

    public function show(Sale $sale)
    {
        $sale->load(['cashier', 'customer', 'details.product']);
        return view('pos.invoice', compact('sale'));
    }

    private function nextInvoiceNumber(): string
    {
        $prefix = 'INV-' . now()->format('Y');

        $last = Sale::where('invoice_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('invoice_number');

        $nextSeq = 1;

        if (!empty($last)) {
            $num = (int) substr($last, -4);
            $nextSeq = $num + 1;
        }

        return $prefix . str_pad((string) $nextSeq, 4, '0', STR_PAD_LEFT);
    }
}
