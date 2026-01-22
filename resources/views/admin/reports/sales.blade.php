@extends('layouts.admin')
@section('title','Sales Report')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
  <div>
    <h2 class="text-xl font-semibold">Sales Report</h2>
    <p class="text-sm text-slate-500">Filter sales by date range</p>
  </div>

  <form method="GET" class="flex flex-wrap items-end gap-2">
    <div>
      <label class="block text-xs text-slate-500 mb-1">From</label>
      <input type="date" name="from" value="{{ request('from') }}"
             class="rounded-lg border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-xs text-slate-500 mb-1">To</label>
      <input type="date" name="to" value="{{ request('to') }}"
             class="rounded-lg border px-3 py-2 text-sm">
    </div>
    <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm hover:bg-slate-800">
      Apply
    </button>
    <a href="{{ route('admin.reports.sales') }}"
       class="px-4 py-2 rounded-lg bg-slate-200 text-slate-800 text-sm hover:bg-slate-300">
      Reset
    </a>
  </form>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
  <div class="p-4 border-b flex items-center justify-between">
    <div class="text-sm text-slate-600">
      Showing {{ $sales->count() }} record(s) on this page
    </div>
    <div class="text-sm font-semibold">
      Page Total: <span class="text-blue-600">${{ number_format($totalFinal ?? 0, 2) }}</span>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600">
        <tr>
          <th class="p-3 text-left">Invoice</th>
          <th class="p-3 text-left">Cashier</th>
          <th class="p-3 text-left">Customer</th>
          <th class="p-3 text-right">Subtotal</th>
          <th class="p-3 text-right">Discount</th>
          <th class="p-3 text-right">Tax</th>
          <th class="p-3 text-right">Final</th>
          <th class="p-3 text-left">Payment</th>
          <th class="p-3 text-left">Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sales as $sale)
          <tr class="border-t">
            <td class="p-3 font-medium">{{ $sale->invoice_number }}</td>
            <td class="p-3">{{ $sale->cashier?->name ?? '-' }}</td>
            <td class="p-3">{{ $sale->customer?->name ?? '-' }}</td>
            <td class="p-3 text-right">${{ number_format($sale->total_amount,2) }}</td>
            <td class="p-3 text-right">${{ number_format($sale->discount,2) }}</td>
            <td class="p-3 text-right">${{ number_format($sale->tax,2) }}</td>
            <td class="p-3 text-right font-semibold text-blue-600">${{ number_format($sale->final_total,2) }}</td>
            <td class="p-3 uppercase text-xs">{{ $sale->payment_type }}</td>
            <td class="p-3 text-xs">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="p-6 text-center text-slate-500">
              No sales found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4">
  {{ $sales->links() }}
</div>
@endsection
