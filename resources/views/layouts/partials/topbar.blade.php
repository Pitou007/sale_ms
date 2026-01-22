<header class="bg-white border-b shadow-sm">
  <div class="flex items-center justify-between px-4 md:px-6 py-3">
    <div class="min-w-0">
      <h1 class="text-lg font-semibold truncate">@yield('title','Admin')</h1>
      <p class="text-xs text-slate-500">Welcome back</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="text-right">
        <div class="text-sm font-medium">{{ auth()->user()->name ?? 'User' }}</div>
        <div class="text-xs text-slate-500">{{ auth()->user()->role ?? '' }}</div>
      </div>

      {{-- Mobile logout --}}
      <form method="POST" action="{{ route('logout') }}" class="md:hidden">
        @csrf
        <button class="text-sm text-red-600 hover:underline">Logout</button>
      </form>
    </div>
  </div>
</header>
