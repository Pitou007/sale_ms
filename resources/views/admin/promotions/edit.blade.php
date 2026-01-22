@extends('layouts.admin')
@section('title','Edit Promotion')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">Edit Promotion</h2>
  <p class="text-sm text-slate-500 mb-6">Update discount for products</p>

  <form method="POST" action="{{ route('admin.promotions.update',$promotion) }}">
    @csrf
    @method('PUT')
    @include('admin.promotions._form', [
      'promotion'=>$promotion,
      'products'=>$products,
      'selected'=>$selected
    ])
  </form>
</div>
@endsection
