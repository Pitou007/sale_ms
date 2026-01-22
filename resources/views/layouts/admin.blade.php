<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title','Admin')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">
  <div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0">
      @include('layouts.partials.topbar')

      <main class="p-4 md:p-6">
        @include('layouts.partials.flash')
        @yield('content')
      </main>
    </div>

  </div>

  @stack('scripts')
</body>
</html>
