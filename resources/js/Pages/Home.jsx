import { Head, Link } from '@inertiajs/react';
import GuestLayout from '../Layouts/GuestLayout';
import BukuCard from '../Components/BukuCard';

export default function Home({ populer, totalJudul, totalKopi, totalAnggota, dipinjam, auth }) {
    const user = auth?.user ?? null;

    const stats = [
        { label: 'Judul Tersedia', nilai: totalJudul, ikon: '📖' },
        { label: 'Total Eksemplar', nilai: totalKopi, ikon: '📚' },
        { label: 'Anggota Terdaftar', nilai: totalAnggota, ikon: '👥' },
        { label: 'Sedang Dipinjam', nilai: dipinjam, ikon: '🔄' },
    ];

    const keunggulan = [
        { judul: 'Cari Cepat', teks: 'Temukan buku lewat judul, penulis, atau penerbit dalam hitungan detik.', ikon: '🔍' },
        { judul: 'Pinjam Online', teks: 'Ajukan peminjaman dari rumah, tanpa perlu antre di loket perpustakaan.', ikon: '⚡' },
        { judul: 'Riwayat Jelas', teks: 'Pantau buku yang sedang Anda pinjam beserta tenggat pengembaliannya.', ikon: '📋' },
    ];

    return (
        <GuestLayout auth={auth}>
            <Head title="Beranda" />

            <section className="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 px-6 py-14 text-white sm:px-12">
                <div className="relative z-10 max-w-2xl">
                    <p className="mb-3 inline-block rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-wide">
                        Perpustakaan Digital
                    </p>
                    <h1 className="text-3xl font-black leading-tight sm:text-5xl">
                        Temukan buku favoritmu,
                        <br />
                        pinjam tanpa antre.
                    </h1>
                    <p className="mt-4 max-w-xl text-emerald-100 sm:text-lg">
                        Jelajahi katalog, cari judul atau penulis favorit, dan kelola peminjaman langsung dari browser.
                    </p>
                    <div className="mt-8 flex flex-wrap gap-3">
                        <Link
                            href="/buku"
                            className="rounded-xl bg-white px-6 py-3 text-sm font-bold text-emerald-800 shadow-lg hover:bg-emerald-50"
                        >
                            Jelajahi Katalog
                        </Link>
                        {!user && (
                            <Link
                                href="/register"
                                className="rounded-xl border border-white/40 px-6 py-3 text-sm font-bold text-white hover:bg-white/10"
                            >
                                Daftar Jadi Anggota
                            </Link>
                        )}
                    </div>
                </div>
                <div className="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/10 blur-2xl"></div>
                <div className="pointer-events-none absolute -bottom-24 right-24 h-72 w-72 rounded-full bg-emerald-400/20 blur-2xl"></div>
            </section>

            <section className="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
                {stats.map((item) => (
                    <div key={item.label} className="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                        <div className="mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-lg">
                            {item.ikon}
                        </div>
                        <p className="text-2xl font-black text-stone-900">{item.nilai}</p>
                        <p className="text-sm text-stone-500">{item.label}</p>
                    </div>
                ))}
            </section>

            <section className="mt-12">
                <div className="mb-5 flex items-end justify-between">
                    <div>
                        <h2 className="text-2xl font-black text-stone-900">Buku Pilihan</h2>
                        <p className="text-sm text-stone-500">Beberapa judul yang lagi banyak diminati.</p>
                    </div>
                    <Link href="/buku" className="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                        Lihat semua →
                    </Link>
                </div>
                <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    {populer.map((buku) => (
                        <BukuCard key={buku.id} buku={buku} />
                    ))}
                </div>
            </section>

            <section className="mt-12 grid gap-5 sm:grid-cols-3">
                {keunggulan.map((item) => (
                    <div key={item.judul} className="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                        <div className="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-xl">
                            {item.ikon}
                        </div>
                        <h3 className="font-bold text-stone-900">{item.judul}</h3>
                        <p className="mt-1 text-sm text-stone-500">{item.teks}</p>
                    </div>
                ))}
            </section>
        </GuestLayout>
    );
}
