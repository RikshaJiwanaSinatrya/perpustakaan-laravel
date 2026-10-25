import { Link, router, usePage } from '@inertiajs/react';
import Flash from '../Components/Flash';

export default function GuestLayout({ children, auth }) {
    const user = auth?.user ?? null;
    const { url } = usePage();
    const path = url.split('?')[0];
    const navClass = (href) =>
        `rounded-lg px-3 py-2 text-sm font-medium ${
            path === href ? 'bg-emerald-50 text-emerald-700' : 'text-stone-600 hover:bg-stone-100 hover:text-stone-900'
        }`;

    const keluar = (e) => {
        e.preventDefault();
        router.post('/logout');
    };

    return (
        <>
            <nav className="sticky top-0 z-40 border-b border-stone-200 bg-white/90 backdrop-blur">
                <div className="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
                    <Link href="/" className="flex items-center gap-2 font-black tracking-tight text-stone-900">
                        <span className="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-600 text-white">
                            📚
                        </span>
                        <span>
                            Perpus<span className="text-emerald-600">Digital</span>
                        </span>
                    </Link>

                    <div className="hidden items-center gap-1 md:flex">
                        <Link href="/" className={navClass('/')}>
                            Beranda
                        </Link>
                        <Link href="/buku" className={navClass('/buku')}>
                            Katalog
                        </Link>
                        {user && user.role !== 'admin' && (
                            <Link href="/pinjaman" className={navClass('/pinjaman')}>
                                Pinjaman Saya
                            </Link>
                        )}
                        {user && user.role === 'admin' && (
                            <Link href="/admin" className={navClass('/admin')}>
                                Dashboard Admin
                            </Link>
                        )}
                    </div>

                    <div className="flex items-center gap-2">
                        {user ? (
                            <>
                                <span className="hidden text-sm text-stone-500 sm:inline">{user.nama}</span>
                                <form onSubmit={keluar}>
                                    <button
                                        type="submit"
                                        className="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100"
                                    >
                                        Keluar
                                    </button>
                                </form>
                            </>
                        ) : (
                            <>
                                <Link href="/login" className="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100">
                                    Masuk
                                </Link>
                                <Link
                                    href="/register"
                                    className="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700"
                                >
                                    Daftar
                                </Link>
                            </>
                        )}
                    </div>
                </div>
            </nav>

            <main className="mx-auto max-w-6xl px-4 py-8">
                <Flash />
                {children}
            </main>

            <footer className="mt-16 border-t border-stone-200 bg-white">
                <div className="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 px-4 py-6 text-sm text-stone-400 sm:flex-row">
                    <p>© {new Date().getFullYear()} PerpusDigital — Demo frontend perpustakaan.</p>
                    <p>Dibangun dengan Laravel + React (Inertia) + Tailwind CSS</p>
                </div>
            </footer>
        </>
    );
}
