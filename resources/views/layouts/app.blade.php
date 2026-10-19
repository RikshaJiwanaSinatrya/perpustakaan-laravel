@php $user = \current_user(); @endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Perpustakaan' }} — Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-50 font-sans text-stone-700 antialiased">
    <nav class="sticky top-0 z-40 border-b border-stone-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
            <a href="/" class="flex items-center gap-2 font-black tracking-tight text-stone-900">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-600 text-white">📚</span>
                <span>Perpus<span class="text-emerald-600">Digital</span></span>
            </a>

            <div class="hidden items-center gap-1 md:flex">
                <a href="/" class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100 hover:text-stone-900">Beranda</a>
                <a href="/buku" class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100 hover:text-stone-900">Katalog</a>
                @if ($user && $user['role'] !== 'admin')
                    <a href="/pinjaman" class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100 hover:text-stone-900">Pinjaman Saya</a>
                @endif
                @if ($user && $user['role'] === 'admin')
                    <a href="/admin" class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100 hover:text-stone-900">Dashboard Admin</a>
                @endif
            </div>

            <div class="flex items-center gap-2">
                @if ($user)
                    <span class="hidden text-sm text-stone-500 sm:inline">{{ $user['nama'] }}</span>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100">Keluar</button>
                    </form>
                @else
                    <a href="/login" class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100">Masuk</a>
                    <a href="/register" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Daftar</a>
                @endif
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-8">
        <x-flash />
        {{ $slot }}
    </main>

    <footer class="mt-16 border-t border-stone-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 px-4 py-6 text-sm text-stone-400 sm:flex-row">
            <p>© {{ date('Y') }} PerpusDigital — Demo frontend perpustakaan.</p>
            <p>Dibangun dengan Laravel + Tailwind CSS</p>
        </div>
    </footer>
</body>
</html>
