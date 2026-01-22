@extends('layouts.admin')
@section('title','Create Product')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">New Product</h2>
  <p class="text-sm text-slate-500 mb-6">Add product into inventory</p>

  <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.products._form')
  </form>
</div>
@endsection
