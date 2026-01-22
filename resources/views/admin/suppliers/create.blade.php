@extends('layouts.admin')
@section('title','Create Supplier')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">New Supplier</h2>
  <p class="text-sm text-slate-500 mb-6">Add supplier</p>

  <form method="POST" action="{{ route('admin.suppliers.store') }}">
    @csrf
    @include('admin.suppliers._form')
  </form>
</div>
@endsection
