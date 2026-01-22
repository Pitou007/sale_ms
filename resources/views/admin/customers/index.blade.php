@extends('layouts.admin')
@section('title','Members / Customers')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
  <div>
    <h2 class="text-xl font-semibold">Customers</h2>
    <p class="text-sm text-slate-500">Manage members/customers</p>
  </div>

  <div class="flex gap-2">
    <form method="GET" class="flex gap-2">
      <input type="text" name="q" value="{{ request('q') }}"
             class="rounded-lg border px-3 py-2 text-sm w-56"
             placeholder="Search name/phone...">
      <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm hover:bg-slate-800">
        Search
      </button>
    </form>

    <a href="{{ route('admin.customers.create') }}"
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
          <th class="p-3 text-left">Phone</th>
          <th class="p-3 text-left">Email</th>
          <th class="p-3 text-left">Address</th>
          <th class="p-3 text-right">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $c)
          <tr class="border-t">
            <td class="p-3 font-medium">{{ $c->name }}</td>
            <td class="p-3">{{ $c->phone ?? '-' }}</td>
            <td class="p-3">{{ $c->email ?? '-' }}</td>
            <td class="p-3">{{ $c->address ?? '-' }}</td>
            <td class="p-3 text-right space-x-3">
              <a class="text-blue-600 hover:underline"
                 href="{{ route('admin.customers.edit',$c) }}">Edit</a>

              <form method="POST" action="{{ route('admin.customers.destroy',$c) }}" class="inline">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline"
                        onclick="return confirm('Delete this customer?')">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="p-6 text-center text-slate-500">
              No customers found.
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
