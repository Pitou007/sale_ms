@extends('layouts.admin')
@section('title','Stock Report')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
  <div>
    <h2 class="text-xl font-semibold">Stock Report</h2>
    <p class="text-sm text-slate-500">Products and current quantities</p>
  </div>

  <form method="GET" class="flex gap-2">
    <input type="text" name="q" value="{{ request('q') }}"
           class="rounded-lg border px-3 py-2 text-sm w-64"
           placeholder="Search name/barcode...">
    <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm hover:bg-slate-800">
      Search
    </button>
    <a href="{{ route('admin.reports.stock') }}"
       class="px-4 py-2 rounded-lg bg-slate-200 text-slate-800 text-sm hover:bg-slate-300">
      Reset
    </a>
  </form>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600">
        <tr>
          <th class="p-3 text-left">Product</th>
          <th class="p-3 text-left">Barcode</th>
          <th class="p-3 text-left">Category</th>
          <th class="p-3 text-left">Supplier</th>
          <th class="p-3 text-right">Cost</th>
          <th class="p-3 text-right">Price</th>
          <th class="p-3 text-right">Qty</th>
          <th class="p-3 text-left">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $p)
          @php
            $low = $p->qty <= 5;
          @endphp
          <tr class="border-t">
            <td class="p-3 font-medium">{{ $p->name }}</td>
            <td class="p-3">{{ $p->barcode }}</td>
            <td class="p-3">{{ $p->category?->name ?? '-' }}</td>
            <td class="p-3">{{ $p->supplier?->name ?? '-' }}</td>
            <td class="p-3 text-right">${{ number_format($p->cost_price,2) }}</td>
            <td class="p-3 text-right">${{ number_format($p->sale_price,2) }}</td>
            <td class="p-3 text-right font-semibold {{ $low ? 'text-red-600' : 'text-slate-900' }}">
              {{ $p->qty }}
            </td>
            <td class="p-3">
              <span class="px-2 py-1 rounded-full text-xs
                {{ $low ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                {{ $low ? 'Low Stock' : 'OK' }}
              </span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="p-6 text-center text-slate-500">
              No products found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4">
  {{ $items->links() }}
</div>
@endsection
