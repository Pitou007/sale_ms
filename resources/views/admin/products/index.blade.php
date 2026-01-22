@extends('layouts.admin')
@section('title','Products')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
  <div>
    <h2 class="text-xl font-semibold">Products</h2>
    <p class="text-sm text-slate-500">Manage products & stock</p>
  </div>

  <div class="flex gap-2">
    <form method="GET" class="flex gap-2">
      <input type="text" name="q" value="{{ request('q') }}"
             class="rounded-lg border px-3 py-2 text-sm w-56"
             placeholder="Search name or barcode...">
      <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm hover:bg-slate-800">
        Search
      </button>
    </form>

    <a href="{{ route('admin.products.create') }}"
       class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">
      + New
    </a>
  </div>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600">
        <tr>
          <th class="p-3 text-left">Product</th>
          <th class="p-3 text-left">Barcode</th>
          <th class="p-3 text-left">Category</th>
          <th class="p-3 text-right">Cost</th>
          <th class="p-3 text-right">Price</th>
          <th class="p-3 text-right">Qty</th>
          <th class="p-3 text-right">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $p)
          <tr class="border-t">
            <td class="p-3">
              <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-slate-100 overflow-hidden flex items-center justify-center">
                  @if($p->image)
                    <img src="{{ asset('storage/'.$p->image) }}" class="h-full w-full object-cover" alt="">
                  @else
                    <span class="text-slate-400 text-xs">IMG</span>
                  @endif
                </div>
                <div>
                  <div class="font-medium">{{ $p->name }}</div>
                  <div class="text-xs text-slate-500">Supplier: {{ $p->supplier?->name ?? '-' }}</div>
                </div>
              </div>
            </td>
            <td class="p-3 font-mono text-xs">{{ $p->barcode }}</td>
            <td class="p-3">{{ $p->category?->name ?? '-' }}</td>
            <td class="p-3 text-right">${{ number_format($p->cost_price,2) }}</td>
            <td class="p-3 text-right font-semibold">${{ number_format($p->sale_price,2) }}</td>
            <td class="p-3 text-right">
              <span class="px-2 py-1 rounded-full text-xs
                {{ $p->qty <= 5 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                {{ $p->qty }}
              </span>
            </td>
            <td class="p-3 text-right space-x-3">
              <a class="text-blue-600 hover:underline"
                 href="{{ route('admin.products.edit',$p) }}">Edit</a>

              <form method="POST" action="{{ route('admin.products.destroy',$p) }}" class="inline">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline"
                        onclick="return confirm('Delete this product?')">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td class="p-6 text-center text-slate-500" colspan="7">No products found.</td>
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
