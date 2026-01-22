<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow p-6">
      <h1 class="text-2xl font-bold">Login</h1>
      <p class="text-sm text-slate-500 mb-6">Sign in to continue</p>

      @if($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 text-red-800 px-4 py-3">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-sm mb-1">Email</label>
          <input type="email" name="email" value="{{ old('email') }}"
                 class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
                 placeholder="admin@example.com" required>
        </div>

        <div>
          <label class="block text-sm mb-1">Password</label>
          <input type="password" name="password"
                 class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-blue-200 outline-none"
                 placeholder="••••••••" required>
        </div>

        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded">
            Remember me
          </label>
        </div>

        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2 font-semibold">
          Sign In
        </button>

        <div class="text-xs text-slate-500 mt-3">
          Default admin: <span class="font-semibold">admin@example.com</span> / <span class="font-semibold">password</span>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
