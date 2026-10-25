import { Link, router, usePage } from '@inertiajs/react';
import Flash from '../Components/Flash';

export default function AdminLayout({ children, auth, title = 'Dashboard' }) {
    const user = auth?.user ?? null;
    const { url } = usePage();
    const path = url.split('?')[0].replace(/^\//, '');

    const navItems = [
        { href: '/admin', icon: '📊', label: 'Dashboard', active: path === 'admin' },
        { href: '/admin/buku', icon: '📖', label: 'Kelola Buku', active: path.startsWith('admin/buku') },
        { href: '/admin/peminjaman', icon: '🔄', label: 'Peminjaman', active: path === 'admin/peminjaman' },
        { href: '/admin/anggota', icon: '👥', label: 'Anggota', active: path === 'admin/anggota' },
    ];

    const keluar = (e) => {
        e.preventDefault();
        router.post('/logout');
    };

    return (
        <div className="flex min-h-screen bg-stone-100">
            <aside className="hidden w-64 shrink-0 flex-col border-r border-stone-800 bg-stone-900 text-stone-300 lg:flex">
                <div className="flex h-16 items-center gap-2 border-b border-stone-800 px-5 font-black tracking-tight text-white">
                    <span className="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-600 text-white">📚</span>
                    <span>
                        Perpus<span className="text-emerald-400">Admin</span>
                    </span>
                </div>

                <nav className="flex-1 space-y-1 p-3">
                    {navItems.map((item) => (
                        <Link
                            key={item.href}
                            href={item.href}
                            className={`flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition ${
                                item.active
                                    ? 'bg-emerald-600 text-white'
                                    : 'text-stone-400 hover:bg-stone-800 hover:text-white'
                            }`}
                        >
                            <span>{item.icon}</span> {item.label}
                        </Link>
                    ))}
                </nav>

                <div className="border-t border-stone-800 p-3">
                    <Link
                        href="/"
                        className="mb-2 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-stone-400 hover:bg-stone-800 hover:text-white"
                    >
                        <span>🌐</span> Lihat Situs
                    </Link>
                    <div className="flex items-center justify-between rounded-lg bg-stone-800 px-3 py-2.5">
                        <div className="min-w-0">
                            <p className="truncate text-sm font-medium text-white">{user?.nama ?? 'Admin'}</p>
                            <p className="truncate text-xs text-stone-400">{user?.email ?? ''}</p>
                        </div>
                        <form onSubmit={keluar}>
                            <button
                                type="submit"
                                title="Keluar"
                                className="ml-2 rounded-md px-2 py-1 text-stone-400 hover:bg-stone-700 hover:text-white"
                            >
                                ⏻
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div className="flex min-w-0 flex-1 flex-col">
                <header className="flex h-16 items-center justify-between border-b border-stone-200 bg-white px-4 lg:px-8">
                    <h1 className="text-lg font-bold text-stone-900">{title}</h1>
                    <div className="flex items-center gap-2 text-sm text-stone-500">
                        <span className="hidden sm:inline">{user?.nama ?? ''}</span>
                        <form onSubmit={keluar}>
                            <button
                                type="submit"
                                className="rounded-lg border border-stone-300 px-3 py-1.5 text-sm font-medium text-stone-600 hover:bg-stone-100 lg:hidden"
                            >
                                Keluar
                            </button>
                        </form>
                    </div>
                </header>

                <div className="border-b border-stone-200 bg-white px-4 lg:hidden">
                    <div className="flex gap-1 overflow-x-auto py-2">
                        {navItems.map((item) => (
                            <Link
                                key={item.href}
                                href={item.href}
                                className={`whitespace-nowrap rounded-lg px-3 py-1.5 text-sm font-medium ${
                                    item.active ? 'bg-emerald-600 text-white' : 'text-stone-600 hover:bg-stone-100'
                                }`}
                            >
                                {item.icon} {item.label}
                            </Link>
                        ))}
                    </div>
                </div>

                <main className="flex-1 p-4 lg:p-8">
                    <Flash />
                    {children}
                </main>
            </div>
        </div>
    );
}
