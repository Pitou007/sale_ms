@extends('layouts.admin')
@section('title','Edit Product')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">Edit Product</h2>
  <p class="text-sm text-slate-500 mb-6">Update product info</p>

  <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.products._form', ['product' => $product])
  </form>
</div>
@endsection
