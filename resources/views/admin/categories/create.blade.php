@extends('layouts.admin')
@section('title','Create Category')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">New Category</h2>
  <p class="text-sm text-slate-500 mb-6">Add product category</p>

  <form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    @include('admin.categories._form')
  </form>
</div>
@endsection
