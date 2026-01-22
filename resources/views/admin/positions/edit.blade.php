@extends('layouts.admin')
@section('title','Edit Position')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">Edit Position</h2>
  <p class="text-sm text-slate-500 mb-6">Update job role</p>

  <form method="POST" action="{{ route('admin.positions.update',$position) }}">
    @csrf
    @method('PUT')
    @include('admin.positions._form', ['position'=>$position])
  </form>
</div>
@endsection
