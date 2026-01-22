@extends('layouts.admin')
@section('title','POS')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

  {{-- LEFT: Products --}}
  <div class="lg:col-span-2 space-y-4">
    <div class="bg-white rounded-2xl shadow p-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
          <h2 class="text-lg font-semibold">Products</h2>
          <p class="text-sm text-slate-500">Search by name or barcode</p>
        </div>

        <div class="flex gap-2">
          <input id="search" type="text"
                 class="w-full md:w-72 rounded-lg border px-3 py-2 text-sm"
                 placeholder="Type name/barcode...">
          <button id="btnSearch"
                  class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm hover:bg-slate-800">
            Search
          </button>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-4">
      <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
        {{-- JS will render products --}}
      </div>

      <div id="productsEmpty" class="hidden text-center text-slate-500 py-8">
        No products found.
      </div>
    </div>
  </div>

  {{-- RIGHT: Cart --}}
  <div class="space-y-4">
    <div class="bg-white rounded-2xl shadow p-4">
      <h2 class="text-lg font-semibold">Cart</h2>
      <p class="text-sm text-slate-500 mb-3">Checkout and print invoice</p>

      <div id="cartList" class="space-y-3"></div>

      <div class="border-t mt-4 pt-4 space-y-2 text-sm">
        <div class="flex justify-between">
          <span class="text-slate-600">Subtotal</span>
          <span class="font-semibold" id="subtotalText">$0.00</span>
        </div>

        <div class="flex justify-between items-center gap-2">
          <span class="text-slate-600">Discount</span>
          <input id="discount" type="number" min="0" step="0.01"
                 class="w-28 rounded-lg border px-2 py-1 text-sm text-right" value="0">
        </div>

        <div class="flex justify-between items-center gap-2">
          <span class="text-slate-600">Tax</span>
          <input id="tax" type="number" min="0" step="0.01"
                 class="w-28 rounded-lg border px-2 py-1 text-sm text-right" value="0">
        </div>

        <div class="flex justify-between text-base">
          <span class="font-semibold">Total</span>
          <span class="font-bold" id="finalText">$0.00</span>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-4">
      <form id="checkoutForm" method="POST" action="{{ route('admin.pos.checkout') }}">
        @csrf

        {{-- Optional: member --}}
        @if(Route::has('admin.customers.index'))
          <label class="block text-sm mb-1">Customer (optional)</label>
          <input type="number" name="customer_id"
                 class="w-full rounded-lg border px-3 py-2 text-sm mb-3"
                 placeholder="Customer ID (optional)">
        @endif

        <label class="block text-sm mb-1">Payment Type</label>
        <select name="payment_type" class="w-full rounded-lg border px-3 py-2 text-sm mb-3" required>
          <option value="cash">Cash</option>
          <option value="qr">QR</option>
          <option value="card">Card</option>
        </select>

        {{-- Hidden inputs populated by JS before submit --}}
        <input type="hidden" name="discount" id="discountInput" value="0">
        <input type="hidden" name="tax" id="taxInput" value="0">

        <div id="itemsInputs"></div>

        <button type="submit"
                class="w-full py-2.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">
          Checkout
        </button>

        <button type="button" id="btnClear"
                class="w-full mt-2 py-2.5 rounded-lg bg-slate-200 text-slate-800 hover:bg-slate-300">
          Clear Cart
        </button>

        <p class="text-xs text-slate-500 mt-3">
          Tip: Add products then checkout. Invoice will open after checkout.
        </p>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  // ------- Server data (simple) -------
  // You should pass $products from controller: Product::select(...)->get()
  // For now, we assume controller returns: return view('pos.index', ['products'=>$products]);
  const PRODUCTS = @json($products ?? []);

  // ------- Helpers -------
  const money = (n) => '$' + Number(n || 0).toFixed(2);

  // cart: { product_id: {id,name,barcode,price,qty} }
  let cart = {};

  const grid = document.getElementById('productsGrid');
  const empty = document.getElementById('productsEmpty');
  const cartList = document.getElementById('cartList');

  const subtotalText = document.getElementById('subtotalText');
  const finalText = document.getElementById('finalText');

  const discountEl = document.getElementById('discount');
  const taxEl = document.getElementById('tax');
  const itemsInputs = document.getElementById('itemsInputs');

  const searchEl = document.getElementById('search');
  const btnSearch = document.getElementById('btnSearch');
  const btnClear = document.getElementById('btnClear');

  function renderProducts(list) {
    grid.innerHTML = '';
    if (!list.length) {
      empty.classList.remove('hidden');
      return;
    }
    empty.classList.add('hidden');

    list.forEach(p => {
      const disabled = (p.qty <= 0);
      const card = document.createElement('div');
      card.className = 'border rounded-xl p-3 bg-slate-50 hover:bg-white transition';

      card.innerHTML = `
        <div class="flex items-start justify-between gap-2">
          <div class="min-w-0">
            <div class="font-semibold truncate">${p.name}</div>
            <div class="text-xs text-slate-500 font-mono truncate">${p.barcode}</div>
          </div>
          <span class="text-xs px-2 py-1 rounded-full ${p.qty<=5 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'}">
            ${p.qty}
          </span>
        </div>

        <div class="mt-2 flex items-center justify-between">
          <div class="text-sm font-bold">${money(p.sale_price)}</div>
          <button ${disabled ? 'disabled' : ''}
            class="px-3 py-1.5 rounded-lg text-sm font-semibold
            ${disabled ? 'bg-slate-200 text-slate-500' : 'bg-slate-900 text-white hover:bg-slate-800'}">
            Add
          </button>
        </div>
      `;

      const btn = card.querySelector('button');
      btn.addEventListener('click', () => addToCart(p));
      grid.appendChild(card);
    });
  }

  function addToCart(p) {
    if (!cart[p.id]) {
      cart[p.id] = { id: p.id, name: p.name, barcode: p.barcode, price: Number(p.sale_price), qty: 1 };
    } else {
      cart[p.id].qty += 1;
    }
    renderCart();
  }

  function changeQty(id, delta) {
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) delete cart[id];
    renderCart();
  }

  function calc() {
    let subtotal = 0;
    Object.values(cart).forEach(it => subtotal += it.qty * it.price);

    const discount = Number(discountEl.value || 0);
    const tax = Number(taxEl.value || 0);
    const final = Math.max(0, subtotal - discount + tax);

    return { subtotal, discount, tax, final };
  }

  function renderCart() {
    cartList.innerHTML = '';
    const items = Object.values(cart);

    if (!items.length) {
      cartList.innerHTML = `<div class="text-sm text-slate-500">Cart is empty.</div>`;
    } else {
      items.forEach(it => {
        const row = document.createElement('div');
        row.className = 'border rounded-xl p-3 bg-white';

        row.innerHTML = `
          <div class="flex justify-between gap-3">
            <div class="min-w-0">
              <div class="font-semibold truncate">${it.name}</div>
              <div class="text-xs text-slate-500 font-mono truncate">${it.barcode}</div>
              <div class="text-sm font-bold mt-1">${money(it.price)}</div>
            </div>

            <div class="flex flex-col items-end gap-2">
              <div class="flex items-center gap-2">
                <button class="w-8 h-8 rounded-lg bg-slate-200 hover:bg-slate-300 font-bold">-</button>
                <div class="w-10 text-center font-semibold">${it.qty}</div>
                <button class="w-8 h-8 rounded-lg bg-slate-900 text-white hover:bg-slate-800 font-bold">+</button>
              </div>
              <div class="text-sm text-slate-700">
                Line: <span class="font-semibold">${money(it.qty * it.price)}</span>
              </div>
            </div>
          </div>
        `;

        const [btnMinus, btnPlus] = row.querySelectorAll('button');
        btnMinus.addEventListener('click', () => changeQty(it.id, -1));
        btnPlus.addEventListener('click', () => changeQty(it.id, +1));
        cartList.appendChild(row);
      });
    }

    // totals
    const { subtotal, final } = calc();
    subtotalText.textContent = money(subtotal);
    finalText.textContent = money(final);
  }

  function applySearch() {
    const q = (searchEl.value || '').trim().toLowerCase();
    if (!q) return renderProducts(PRODUCTS);

    const filtered = PRODUCTS.filter(p =>
      (p.name || '').toLowerCase().includes(q) ||
      (p.barcode || '').toLowerCase().includes(q)
    );
    renderProducts(filtered);
  }

  btnSearch.addEventListener('click', applySearch);
  searchEl.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') { e.preventDefault(); applySearch(); }
  });

  discountEl.addEventListener('input', renderCart);
  taxEl.addEventListener('input', renderCart);

  btnClear.addEventListener('click', () => {
    cart = {};
    discountEl.value = 0;
    taxEl.value = 0;
    renderCart();
  });

  // Before submit: create inputs items[0][...]
  document.getElementById('checkoutForm').addEventListener('submit', (e) => {
    const items = Object.values(cart);
    if (!items.length) {
      e.preventDefault();
      alert('Cart is empty!');
      return;
    }

    // sync discount/tax hidden
    document.getElementById('discountInput').value = Number(discountEl.value || 0);
    document.getElementById('taxInput').value = Number(taxEl.value || 0);

    itemsInputs.innerHTML = '';
    items.forEach((it, idx) => {
      itemsInputs.insertAdjacentHTML('beforeend', `
        <input type="hidden" name="items[${idx}][product_id]" value="${it.id}">
        <input type="hidden" name="items[${idx}][qty]" value="${it.qty}">
        <input type="hidden" name="items[${idx}][price]" value="${it.price}">
      `);
    });
  });

  // initial render
  renderProducts(PRODUCTS);
  renderCart();
</script>
@endpush
