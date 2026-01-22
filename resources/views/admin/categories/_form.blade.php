@php $isEdit = isset($category); @endphp

<div class="space-y-4">
  <div>
    <label class="block text-sm mb-1">Category Name</label>
    <input type="text" name="name"
           value="{{ old('name', $category->name ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
           required>
    @error('name') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="flex gap-2 pt-2">
    <button class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold">
      {{ $isEdit ? 'Update' : 'Create' }}
    </button>

    <a href="{{ route('admin.categories.index') }}"
       class="px-5 py-2 rounded-lg bg-slate-200 text-slate-800 hover:bg-slate-300">
      Cancel
    </a>
  </div>
</div>
