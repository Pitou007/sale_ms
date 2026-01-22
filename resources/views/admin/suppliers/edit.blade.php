@extends('layouts.admin')
@section('title','Edit Supplier')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">Edit Supplier</h2>
  <p class="text-sm text-slate-500 mb-6">Update supplier</p>

  <form method="POST" action="{{ route('admin.suppliers.update',$supplier) }}">
    @csrf
    @method('PUT')
    @include('admin.suppliers._form', ['supplier'=>$supplier])
  </form>
</div>
@endsection
