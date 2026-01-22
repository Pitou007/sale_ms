@extends('layouts.admin')
@section('title','Create Promotion')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">New Promotion</h2>
  <p class="text-sm text-slate-500 mb-6">Create discount for products</p>

  <form method="POST" action="{{ route('admin.promotions.store') }}">
    @csrf
    @include('admin.promotions._form', ['products'=>$products])
  </form>
</div>
@endsection
