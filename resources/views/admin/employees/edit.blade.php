@extends('layouts.admin')
@section('title','Edit Employee')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">Edit Employee</h2>
  <p class="text-sm text-slate-500 mb-6">Update staff</p>

  <form method="POST" action="{{ route('admin.employees.update',$employee) }}">
    @csrf
    @method('PUT')
    @include('admin.employees._form', ['employee'=>$employee, 'positions'=>$positions])
  </form>
</div>
@endsection
