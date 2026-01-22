
@extends('layouts.admin')
@section('title','Create Position')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-1">New Position</h2>
  <p class="text-sm text-slate-500 mb-6">Add job role</p>

  <form method="POST" action="{{ route('admin.positions.store') }}">
    @csrf
    @include('admin.positions._form')
  </form>
</div>
@endsection
