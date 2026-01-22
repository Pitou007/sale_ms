@php
  $isEdit = isset($promotion);
  $selectedIds = old('product_ids', $selected ?? []);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

  <div class="md:col-span-2">
    <label class="block text-sm mb-1">Promotion Name</label>
    <input type="text" name="name"
           value="{{ old('name', $promotion->name ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
           required>
    @error('name') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Type</label>
    <select name="type"
            class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
            required>
      <option value="percent" @selected(old('type', $promotion->type ?? '') === 'percent')>Percent</option>
      <option value="amount"  @selected(old('type', $promotion->type ?? '') === 'amount')>Amount</option>
    </select>
    @error('type') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Value</label>
    <input type="number" step="0.01" min="0" name="value"
           value="{{ old('value', $promotion->value ?? 0) }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
           required>
    @error('value') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Start Date</label>
    <input type="date" name="start_date"
           value="{{ old('start_date', $promotion->start_date ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none">
    @error('start_date') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">End Date</label>
    <input type="date" name="end_date"
           value="{{ old('end_date', $promotion->end_date ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none">
    @error('end_date') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="md:col-span-2">
    <label class="inline-flex items-center gap-2 text-sm">
      <input type="checkbox" name="is_active" value="1"
             class="rounded"
             @checked(old('is_active', $promotion->is_active ?? false))>
      Active
    </label>
  </div>

  <div class="md:col-span-2">
    <label class="block text-sm mb-1">Products in this Promotion</label>
    <select name="product_ids[]" multiple
            class="w-full rounded-lg border px-3 py-2 h-56 focus:ring-2 focus:ring-blue-200 outline-none">
      @foreach($products as $p)
        <option value="{{ $p->id }}" @selected(in_array($p->id, $selectedIds))>
          {{ $p->name }} ({{ $p->barcode }}) - ${{ number_format($p->sale_price,2) }} | Qty: {{ $p->qty }}
        </option>
      @endforeach
    </select>
    <p class="text-xs text-slate-500 mt-1">Hold Ctrl (Windows) / Cmd (Mac) to select multiple</p>
    @error('product_ids') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="md:col-span-2 flex gap-2 pt-2">
    <button class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold">
      {{ $isEdit ? 'Update' : 'Create' }}
    </button>
    <a href="{{ route('admin.promotions.index') }}"
       class="px-5 py-2 rounded-lg bg-slate-200 text-slate-800 hover:bg-slate-300">
      Cancel
    </a>
  </div>

</div>
