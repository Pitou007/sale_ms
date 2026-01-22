@extends('layouts.admin')
@section('title','Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

  <div class="bg-white rounded shadow p-4">
    <div class="text-sm text-slate-500">Today Sales</div>
    <div class="text-2xl font-bold">${{ number_format($todaySales,2) }}</div>
  </div>

  <div class="bg-white rounded shadow p-4">
    <div class="text-sm text-slate-500">Invoices</div>
    <div class="text-2xl font-bold">{{ $todayInvoices }}</div>
  </div>

</div>

<div class="mt-8 bg-white rounded shadow">
  <div class="p-4 font-semibold border-b">Low Stock</div>
  <table class="w-full text-sm">
    <thead class="bg-slate-50">
      <tr>
        <th class="p-3 text-left">Product</th>
        <th class="p-3 text-right">Qty</th>
      </tr>
    </thead>
    <tbody>
      @foreach($lowStock as $p)
      <tr class="border-t">
        <td class="p-3">{{ $p->name }}</td>
        <td class="p-3 text-right text-red-600 font-semibold">
          {{ $p->qty }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
