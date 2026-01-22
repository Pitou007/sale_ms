@extends('layouts.admin')
@section('title','Create Customer')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">New Customer</h2>
  <p class="text-sm text-slate-500 mb-6">Add member/customer</p>

  <form method="POST" action="{{ route('admin.customers.store') }}">
    @csrf
    @include('admin.customers._form')
  </form>
</div>
@endsection
