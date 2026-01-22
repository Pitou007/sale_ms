@php $isEdit = isset($employee); @endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div class="md:col-span-2">
    <label class="block text-sm mb-1">Name</label>
    <input type="text" name="name"
           value="{{ old('name', $employee->name ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
           required>
    @error('name') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Position</label>
    <select name="position_id"
            class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
            required>
      <option value="">-- Select --</option>
      @foreach($positions as $p)
        <option value="{{ $p->id }}"
          @selected(old('position_id', $employee->position_id ?? '') == $p->id)>
          {{ $p->name }}
        </option>
      @endforeach
    </select>
    @error('position_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Start Date</label>
    <input type="date" name="start_date"
           value="{{ old('start_date', $employee->start_date ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none">
    @error('start_date') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Phone</label>
    <input type="text" name="phone"
           value="{{ old('phone', $employee->phone ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none">
    @error('phone') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Email</label>
    <input type="email" name="email"
           value="{{ old('email', $employee->email ?? '') }}"
           class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none">
    @error('email') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="md:col-span-2 flex gap-2 pt-2">
    <button class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold">
      {{ $isEdit ? 'Update' : 'Create' }}
    </button>
    <a href="{{ route('admin.employees.index') }}"
       class="px-5 py-2 rounded-lg bg-slate-200 text-slate-800 hover:bg-slate-300">
      Cancel
    </a>
  </div>
</div>
