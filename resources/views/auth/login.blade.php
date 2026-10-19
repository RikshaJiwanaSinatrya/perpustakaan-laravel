<x-layouts.app :title="'Masuk'">
    <div class="mx-auto max-w-md">
        <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm">
            <div class="mb-6 text-center">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">📚</div>
                <h1 class="text-2xl font-black text-stone-900">Masuk ke Akunmu</h1>
                <p class="mt-1 text-sm text-stone-500">Belum punya akun? <a href="/register" class="font-semibold text-emerald-700 hover:underline">Daftar di sini</a></p>
            </div>

            <form method="POST" action="/login" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-stone-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                           placeholder="nama@contoh.id">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-stone-700">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                           placeholder="••••••••">
                </div>
                <button type="submit" class="w-full rounded-xl bg-emerald-600 py-3 text-sm font-bold text-white hover:bg-emerald-700">
                    Masuk
                </button>
            </form>

            <div class="mt-6 rounded-xl bg-stone-50 p-4 text-xs text-stone-500">
                <p class="mb-1 font-semibold text-stone-600">Akun demo (password: <code class="rounded bg-stone-200 px-1">password</code>)</p>
                <p>👤 Anggota — budi@contoh.id, siti@contoh.id</p>
                <p>🛡️ Admin — admin@perpus.id</p>
            </div>
        </div>
    </div>
</x-layouts.app>
