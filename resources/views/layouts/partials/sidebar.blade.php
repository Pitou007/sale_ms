<aside class="w-64 bg-slate-900 text-white hidden md:flex flex-col">
  <div class="p-4 border-b border-slate-700">
    <div class="text-xl font-bold">Sale MS</div>
    <div class="text-xs text-slate-400">Admin & POS</div>
  </div>

  <nav class="flex-1 p-3 space-y-1 text-sm overflow-y-auto">

    <a href="{{ route('admin.dashboard') }}"
       class="block px-3 py-2 rounded hover:bg-slate-800">
      Dashboard
    </a>

    <a href="{{ route('admin.pos.index') }}"
       class="block px-3 py-2 rounded hover:bg-slate-800">
      POS
    </a>

    <div class="pt-4 text-xs text-slate-400 uppercase">Products</div>

    <a href="{{ route('admin.products.index') }}"
       class="block px-3 py-2 rounded hover:bg-slate-800">
      Products
    </a>

    {{-- If you already created these routes, keep them. If not, remove. --}}
    @if(Route::has('admin.categories.index'))
      <a href="{{ route('admin.categories.index') }}"
         class="block px-3 py-2 rounded hover:bg-slate-800">
        Categories
      </a>
    @endif

    @if(Route::has('admin.promotions.index'))
      <a href="{{ route('admin.promotions.index') }}"
         class="block px-3 py-2 rounded hover:bg-slate-800">
        Promotions
      </a>
    @endif

    <div class="pt-4 text-xs text-slate-400 uppercase">People</div>

    @if(Route::has('admin.customers.index'))
      <a href="{{ route('admin.customers.index') }}"
         class="block px-3 py-2 rounded hover:bg-slate-800">
        Members
      </a>
    @endif

    @if(Route::has('admin.employees.index'))
      <a href="{{ route('admin.employees.index') }}"
         class="block px-3 py-2 rounded hover:bg-slate-800">
        Employees
      </a>
    @endif

    <div class="pt-4 text-xs text-slate-400 uppercase">Reports</div>

    @if(Route::has('admin.reports.sales'))
      <a href="{{ route('admin.reports.sales') }}"
         class="block px-3 py-2 rounded hover:bg-slate-800">
        Sales Report
      </a>
    @endif

  </nav>

  <div class="p-3 border-t border-slate-700">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="w-full px-3 py-2 rounded bg-red-600 hover:bg-red-700 text-sm">
        Logout
      </button>
    </form>
  </div>
</aside>
