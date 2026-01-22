@extends('layouts.admin')
@section('title','Categories')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
  <div>
    <h2 class="text-xl font-semibold">Categories</h2>
    <p class="text-sm text-slate-500">Manage product categories</p>
  </div>

  <div class="flex gap-2">
    <form method="GET" class="flex gap-2">
      <input type="text" name="q" value="{{ request('q') }}"
             class="rounded-lg border px-3 py-2 text-sm w-56"
             placeholder="Search category...">
      <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm hover:bg-slate-800">
        Search
      </button>
    </form>

    <a href="{{ route('admin.categories.create') }}"
       class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">
      + New
    </a>
  </div>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-slate-50 text-slate-600">
      <tr>
        <th class="p-3 text-left">Name</th>
        <th class="p-3 text-left">Created</th>
        <th class="p-3 text-right">Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $cat)
        <tr class="border-t">
          <td class="p-3 font-medium">{{ $cat->name }}</td>
          <td class="p-3 text-xs">{{ $cat->created_at?->format('Y-m-d') }}</td>
          <td class="p-3 text-right space-x-3">
            <a href="{{ route('admin.categories.edit',$cat) }}" class="text-blue-600 hover:underline">
              Edit
            </a>

            <form method="POST" action="{{ route('admin.categories.destroy',$cat) }}" class="inline">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline"
                      onclick="return confirm('Delete this category?')">
                Delete
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="3" class="p-6 text-center text-slate-500">
            No categories found.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $items->links() }}
</div>
@endsection
