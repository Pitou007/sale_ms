@extends('layouts.admin')
@section('title','Promotions')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
  <div>
    <h2 class="text-xl font-semibold">Promotions</h2>
    <p class="text-sm text-slate-500">Discount rules for products</p>
  </div>

  <div class="flex gap-2">
    <form method="GET" class="flex gap-2">
      <input type="text" name="q" value="{{ request('q') }}"
             class="rounded-lg border px-3 py-2 text-sm w-56"
             placeholder="Search promotion...">
      <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm hover:bg-slate-800">
        Search
      </button>
    </form>

    <a href="{{ route('admin.promotions.create') }}"
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
          <th class="p-3 text-left">Name</th>
          <th class="p-3 text-left">Type</th>
          <th class="p-3 text-right">Value</th>
          <th class="p-3 text-left">Dates</th>
          <th class="p-3 text-left">Status</th>
          <th class="p-3 text-right">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $p)
          <tr class="border-t">
            <td class="p-3 font-medium">{{ $p->name }}</td>
            <td class="p-3 uppercase text-xs font-semibold">{{ $p->type }}</td>
            <td class="p-3 text-right">
              @if($p->type === 'percent')
                {{ number_format($p->value,2) }}%
              @else
                ${{ number_format($p->value,2) }}
              @endif
            </td>
            <td class="p-3 text-xs text-slate-600">
              <div>Start: {{ $p->start_date ?? '-' }}</div>
              <div>End: {{ $p->end_date ?? '-' }}</div>
            </td>
            <td class="p-3">
              <span class="px-2 py-1 rounded-full text-xs
                {{ $p->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-700' }}">
                {{ $p->is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td class="p-3 text-right space-x-3">
              <a class="text-blue-600 hover:underline"
                 href="{{ route('admin.promotions.edit',$p) }}">Edit</a>

              <form method="POST" action="{{ route('admin.promotions.destroy',$p) }}" class="inline">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline"
                        onclick="return confirm('Delete this promotion?')">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="p-6 text-center text-slate-500">
              No promotions found.
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
