@php $user = \current_user(); @endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — Admin PerpusDigital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-100 font-sans text-stone-700 antialiased">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 shrink-0 flex-col border-r border-stone-800 bg-stone-900 text-stone-300 lg:flex">
            <div class="flex h-16 items-center gap-2 border-b border-stone-800 px-5 font-black tracking-tight text-white">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-600 text-white">📚</span>
                <span>Perpus<span class="text-emerald-400">Admin</span></span>
            </div>

            <nav class="flex-1 space-y-1 p-3">
                @php
                    $path = request()->path();
                    $navItems = [
                        ['/admin', '📊', 'Dashboard', $path === 'admin'],
                        ['/admin/buku', '📖', 'Kelola Buku', str_starts_with($path, 'admin/buku')],
                        ['/admin/peminjaman', '🔄', 'Peminjaman', $path === 'admin/peminjaman'],
                        ['/admin/anggota', '👥', 'Anggota', $path === 'admin/anggota'],
                    ];
                @endphp
                @foreach ($navItems as [$href, $icon, $label, $active])
                    <a href="{{ $href }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $active ? 'bg-emerald-600 text-white' : 'text-stone-400 hover:bg-stone-800 hover:text-white' }}">
                        <span>{{ $icon }}</span> {{ $label }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-stone-800 p-3">
                <a href="/" class="mb-2 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-stone-400 hover:bg-stone-800 hover:text-white">
                    <span>🌐</span> Lihat Situs
                </a>
                <div class="flex items-center justify-between rounded-lg bg-stone-800 px-3 py-2.5">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium text-white">{{ $user['nama'] ?? 'Admin' }}</p>
                        <p class="truncate text-xs text-stone-400">{{ $user['email'] ?? '' }}</p>
                    </div>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" title="Keluar" class="ml-2 rounded-md px-2 py-1 text-stone-400 hover:bg-stone-700 hover:text-white">⏻</button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex h-16 items-center justify-between border-b border-stone-200 bg-white px-4 lg:px-8">
                <h1 class="text-lg font-bold text-stone-900">{{ $title ?? 'Dashboard' }}</h1>
                <div class="flex items-center gap-2 text-sm text-stone-500">
                    <span class="hidden sm:inline">{{ $user['nama'] ?? '' }}</span>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="rounded-lg border border-stone-300 px-3 py-1.5 text-sm font-medium text-stone-600 hover:bg-stone-100 lg:hidden">Keluar</button>
                    </form>
                </div>
            </header>

            <div class="border-b border-stone-200 bg-white px-4 lg:hidden">
                <div class="flex gap-1 overflow-x-auto py-2">
                    @foreach ($navItems as [$href, $icon, $label, $active])
                        <a href="{{ $href }}"
                           class="whitespace-nowrap rounded-lg px-3 py-1.5 text-sm font-medium {{ $active ? 'bg-emerald-600 text-white' : 'text-stone-600 hover:bg-stone-100' }}">
                            {{ $icon }} {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <main class="flex-1 p-4 lg:p-8">
                <x-flash />
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
