<x-layouts.app :title="'Daftar Akun'">
    <div class="mx-auto max-w-md">
        <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm">
            <div class="mb-6 text-center">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">📝</div>
                <h1 class="text-2xl font-black text-stone-900">Daftar Jadi Anggota</h1>
                <p class="mt-1 text-sm text-stone-500">Sudah punya akun? <a href="/login" class="font-semibold text-emerald-700 hover:underline">Masuk di sini</a></p>
            </div>

            <form method="POST" action="/register" class="space-y-4">
                @csrf
                <div>
                    <label for="nama" class="mb-1.5 block text-sm font-medium text-stone-700">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required autofocus
                           class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                           placeholder="Nama lengkap Anda">
                </div>
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-stone-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                           placeholder="nama@contoh.id">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-stone-700">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                           placeholder="Minimal 6 karakter">
                </div>
                <button type="submit" class="w-full rounded-xl bg-emerald-600 py-3 text-sm font-bold text-white hover:bg-emerald-700">
                    Daftar Sekarang
                </button>
            </form>

            <p class="mt-6 text-center text-xs text-stone-400">
                Registrasi hanya untuk demo frontend — data disimpan sementara di session browser.
            </p>
        </div>
    </div>
</x-layouts.app>
