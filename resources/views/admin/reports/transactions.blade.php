@extends('layouts.admin')
@section('title','Transactions Report')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
  <div>
    <h2 class="text-xl font-semibold">Transactions Report</h2>
    <p class="text-sm text-slate-500">Stock in/out/sale/broken/transfer</p>
  </div>

  <form method="GET" class="flex flex-wrap items-end gap-2">
    <div>
      <label class="block text-xs text-slate-500 mb-1">Type</label>
      <select name="type" class="rounded-lg border px-3 py-2 text-sm">
        <option value="">All</option>
        @foreach(['in','out','sale','return','broken','transfer'] as $t)
          <option value="{{ $t }}" @selected(request('type')===$t)>{{ strtoupper($t) }}</option>
        @endforeach
      </select>
    </div>

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

    <a href="{{ route('admin.reports.transactions') }}"
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
          <th class="p-3 text-left">Date</th>
          <th class="p-3 text-left">Type</th>
          <th class="p-3 text-left">Product</th>
          <th class="p-3 text-right">Qty</th>
          <th class="p-3 text-left">Supplier</th>
          <th class="p-3 text-left">User</th>
          <th class="p-3 text-left">Note</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $tr)
          <tr class="border-t">
            <td class="p-3 text-xs">{{ $tr->date }}</td>
            <td class="p-3">
              <span class="px-2 py-1 rounded-full text-xs bg-slate-200 text-slate-700 uppercase">
                {{ $tr->type }}
              </span>
            </td>
            <td class="p-3 font-medium">
              {{ $tr->product?->name ?? '-' }}
              <div class="text-xs text-slate-500">{{ $tr->product?->barcode ?? '' }}</div>
            </td>
            <td class="p-3 text-right font-semibold">{{ $tr->qty }}</td>
            <td class="p-3">{{ $tr->supplier?->name ?? '-' }}</td>
            <td class="p-3">{{ $tr->user?->name ?? '-' }}</td>
            <td class="p-3 text-xs text-slate-600">{{ $tr->note ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="p-6 text-center text-slate-500">
              No transactions found.
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
