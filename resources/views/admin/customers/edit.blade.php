@extends('layouts.admin')
@section('title','Edit Customer')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">Edit Customer</h2>
  <p class="text-sm text-slate-500 mb-6">Update member/customer</p>

  <form method="POST" action="{{ route('admin.customers.update',$customer) }}">
    @csrf
    @method('PUT')
    @include('admin.customers._form', ['customer'=>$customer])
  </form>
</div>
@endsection
