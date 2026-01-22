@extends('layouts.admin')
@section('title','Create Employee')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">New Employee</h2>
  <p class="text-sm text-slate-500 mb-6">Add staff</p>

  <form method="POST" action="{{ route('admin.employees.store') }}">
    @csrf
    @include('admin.employees._form', ['positions'=>$positions])
  </form>
</div>
@endsection
