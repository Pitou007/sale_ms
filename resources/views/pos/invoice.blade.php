@extends('layouts.admin')
@section('title','Invoice')

@section('content')
<div class="max-w-3xl mx-auto">

  <div class="bg-white rounded-2xl shadow p-6">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold">INVOICE</h2>
        <p class="text-sm text-slate-500">Invoice: <span class="font-semibold">{{ $sale->invoice_number }}</span></p>
        <p class="text-sm text-slate-500">Date: {{ $sale->created_at->format('Y-m-d H:i') }}</p>
      </div>

      <div class="text-right text-sm">
        <div class="font-semibold">Cashier</div>
        <div class="text-slate-600">{{ $sale->cashier?->name ?? '-' }}</div>

        <div class="mt-2 font-semibold">Customer</div>
        <div class="text-slate-600">{{ $sale->customer?->name ?? 'Walk-in' }}</div>
      </div>
    </div>

    <div class="mt-6 overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="p-3 text-left">Product</th>
            <th class="p-3 text-right">Price</th>
            <th class="p-3 text-right">Qty</th>
            <th class="p-3 text-right">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach($sale->details as $d)
          <tr class="border-t">
            <td class="p-3">
              <div class="font-medium">{{ $d->product?->name ?? 'Product' }}</div>
              <div class="text-xs text-slate-500 font-mono">{{ $d->product?->barcode ?? '' }}</div>
            </td>
            <td class="p-3 text-right">${{ number_format($d->price,2) }}</td>
            <td class="p-3 text-right">{{ $d->qty }}</td>
            <td class="p-3 text-right font-semibold">${{ number_format($d->subtotal,2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-6 border-t pt-4 text-sm space-y-2">
      <div class="flex justify-between">
        <span class="text-slate-600">Subtotal</span>
        <span class="font-semibold">${{ number_format($sale->total_amount,2) }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-slate-600">Discount</span>
        <span class="font-semibold">${{ number_format($sale->discount,2) }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-slate-600">Tax</span>
        <span class="font-semibold">${{ number_format($sale->tax,2) }}</span>
      </div>

      <div class="flex justify-between text-base pt-2 border-t">
        <span class="font-bold">Final Total</span>
        <span class="font-bold">${{ number_format($sale->final_total,2) }}</span>
      </div>

      <div class="flex justify-between">
        <span class="text-slate-600">Payment Type</span>
        <span class="font-semibold uppercase">{{ $sale->payment_type }}</span>
      </div>
    </div>

    <div class="mt-6 flex gap-2 print:hidden">
      <button onclick="window.print()"
              class="px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-slate-800">
        Print
      </button>
      <a href="{{ route('admin.pos.index') }}"
         class="px-4 py-2 rounded-lg bg-slate-200 text-slate-800 hover:bg-slate-300">
        Back to POS
      </a>
    </div>
  </div>

</div>
@endsection
