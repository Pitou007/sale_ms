@php
  $isEdit = isset($product);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

  <div class="md:col-span-2">
    <label class="block text-sm mb-1">Name</label>
    <input type="text" name="name"
           value="{{ old('name', $product->name ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
           required>
    @error('name') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Barcode (Unique)</label>
    <input type="text" name="barcode"
           value="{{ old('barcode', $product->barcode ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
           required>
    @error('barcode') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Category</label>
    <select name="category_id"
            class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
            required>
      <option value="">-- Select --</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}"
          @selected(old('category_id', $product->category_id ?? '') == $c->id)>
          {{ $c->name }}
        </option>
      @endforeach
    </select>
    @error('category_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Supplier</label>
    <select name="supplier_id"
            class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none">
      <option value="">-- None --</option>
      @foreach($suppliers as $s)
        <option value="{{ $s->id }}"
          @selected(old('supplier_id', $product->supplier_id ?? '') == $s->id)>
          {{ $s->name }}
        </option>
      @endforeach
    </select>
    @error('supplier_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Cost Price</label>
    <input type="number" step="0.01" min="0" name="cost_price"
           value="{{ old('cost_price', $product->cost_price ?? 0) }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
           required>
    @error('cost_price') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Sale Price</label>
    <input type="number" step="0.01" min="0" name="sale_price"
           value="{{ old('sale_price', $product->sale_price ?? 0) }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
           required>
    @error('sale_price') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Qty (Current Stock)</label>
    <input type="number" min="0" name="qty"
           value="{{ old('qty', $product->qty ?? 0) }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
           required>
    @error('qty') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Image</label>
    <input type="file" name="image"
           class="w-full rounded-lg border px-3 py-2 bg-white">
    @error('image') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror

    @if(!empty($product?->image))
      <img src="{{ asset('storage/'.$product->image) }}" class="mt-2 h-20 w-20 rounded-lg object-cover" alt="">
    @endif
  </div>

  <div class="md:col-span-2 flex gap-2 pt-2">
    <button class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold">
      {{ $isEdit ? 'Update' : 'Create' }}
    </button>
    <a href="{{ route('admin.products.index') }}"
       class="px-5 py-2 rounded-lg bg-slate-200 text-slate-800 hover:bg-slate-300">
      Cancel
    </a>
  </div>

</div>
