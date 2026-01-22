@if(session('ok'))
  <div class="mb-4 rounded-lg bg-green-100 text-green-800 px-4 py-3">
    {{ session('ok') }}
  </div>
@endif

@if(session('error'))
  <div class="mb-4 rounded-lg bg-red-100 text-red-800 px-4 py-3">
    {{ session('error') }}
  </div>
@endif

@if($errors->any())
  <div class="mb-4 rounded-lg bg-red-100 text-red-800 px-4 py-3">
    {{ $errors->first() }}
  </div>
@endif
