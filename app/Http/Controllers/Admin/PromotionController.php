<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $items = Promotion::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.promotions.index', compact('items', 'q'));
    }

    public function create()
    {
        // list products to attach
        $products = Product::select('id', 'name', 'barcode', 'sale_price', 'qty')
            ->orderBy('name')
            ->get();

        return view('admin.promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:promotions,name'],
            'type' => ['required', 'in:percent,amount'], // percent or fixed amount
            'value' => ['required', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer', 'exists:products,id'],
        ]);

        $promo = Promotion::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'value' => $data['value'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? false),
        ]);

        // attach products (pivot)
        $promo->products()->sync($data['product_ids'] ?? []);

        return redirect()->route('admin.promotions.index')->with('ok', 'Promotion created');
    }

    public function edit(Promotion $promotion)
    {
        $products = Product::select('id', 'name', 'barcode', 'sale_price', 'qty')
            ->orderBy('name')
            ->get();

        $selected = $promotion->products()->pluck('products.id')->toArray();

        return view('admin.promotions.edit', compact('promotion', 'products', 'selected'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:promotions,name,' . $promotion->id],
            'type' => ['required', 'in:percent,amount'],
            'value' => ['required', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer', 'exists:products,id'],
        ]);

        $promotion->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'value' => $data['value'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? false),
        ]);

        $promotion->products()->sync($data['product_ids'] ?? []);

        return redirect()->route('admin.promotions.index')->with('ok', 'Promotion updated');
    }

    public function destroy(Promotion $promotion)
    {
        // detach pivot first
        $promotion->products()->detach();
        $promotion->delete();

        return back()->with('ok', 'Promotion deleted');
    }
}
