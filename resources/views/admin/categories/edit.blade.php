@extends('layouts.admin')
@section('title','Edit Category')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">Edit Category</h2>
  <p class="text-sm text-slate-500 mb-6">Update category</p>

  <form method="POST" action="{{ route('admin.categories.update',$category) }}">
    @csrf
    @method('PUT')
    @include('admin.categories._form', ['category'=>$category])
  </form>
</div>
@endsection
