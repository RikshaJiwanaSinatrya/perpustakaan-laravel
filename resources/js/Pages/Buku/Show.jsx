import { Head, Link, router } from '@inertiajs/react';
import GuestLayout from '../../Layouts/GuestLayout';
import { inisial } from '../../lib/format';

export default function Show({ buku, tersedia, auth }) {
    const user = auth?.user ?? null;

    const pinjam = () => {
        if (confirm(`Pinjam buku "${buku.judul}"?`)) {
            router.post(`/pinjaman/${buku.id}`);
        }
    };

    return (
        <GuestLayout auth={auth}>
            <Head title={buku.judul} />

            <nav className="mb-6 text-sm text-stone-400">
                <Link href="/" className="hover:text-emerald-700">
                    Beranda
                </Link>{' '}
                /{' '}
                <Link href="/buku" className="hover:text-emerald-700">
                    Katalog
                </Link>{' '}
                / <span className="text-stone-600">{buku.judul}</span>
            </nav>

            <div className="grid gap-10 lg:grid-cols-[320px_1fr]">
                <div
                    className={`flex h-72 items-center justify-center rounded-3xl bg-gradient-to-br ${buku.warna} shadow-xl sm:h-96`}
                >
                    <span className="text-8xl font-black text-white/80">{inisial(buku.judul)}</span>
                </div>

                <div>
                    <span className="inline-block rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                        {buku.kategori}
                    </span>
                    <h1 className="mt-3 text-3xl font-black leading-tight text-stone-900 sm:text-4xl">{buku.judul}</h1>
                    <p className="mt-2 text-lg text-stone-500">oleh {buku.penulis}</p>

                    <dl className="mt-6 grid grid-cols-2 gap-4 rounded-2xl border border-stone-200 bg-white p-5 text-sm sm:grid-cols-4">
                        <div>
                            <dt className="text-stone-400">Penerbit</dt>
                            <dd className="mt-0.5 font-semibold text-stone-800">{buku.penerbit}</dd>
                        </div>
                        <div>
                            <dt className="text-stone-400">Tahun</dt>
                            <dd className="mt-0.5 font-semibold text-stone-800">{buku.tahun}</dd>
                        </div>
                        <div>
                            <dt className="text-stone-400">ISBN</dt>
                            <dd className="mt-0.5 font-semibold text-stone-800">{buku.isbn}</dd>
                        </div>
                        <div>
                            <dt className="text-stone-400">Stok Tersedia</dt>
                            <dd className={`mt-0.5 font-semibold ${tersedia > 0 ? 'text-emerald-600' : 'text-rose-600'}`}>
                                {tersedia} / {buku.stok}
                            </dd>
                        </div>
                    </dl>

                    <div className="mt-6">
                        <h2 className="font-bold text-stone-900">Sinopsis</h2>
                        <p className="mt-2 leading-relaxed text-stone-600">{buku.deskripsi}</p>
                    </div>

                    <div className="mt-8">
                        {tersedia <= 0 ? (
                            <div className="inline-block rounded-xl bg-rose-50 px-5 py-3 text-sm font-semibold text-rose-700">
                                Maaf, stok buku ini sedang habis.
                            </div>
                        ) : !user ? (
                            <>
                                <Link
                                    href="/login"
                                    className="inline-block rounded-xl bg-emerald-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg hover:bg-emerald-700"
                                >
                                    Masuk untuk Meminjam
                                </Link>
                                <p className="mt-2 text-sm text-stone-400">
                                    Anda perlu login sebagai anggota terlebih dahulu.
                                </p>
                            </>
                        ) : user.role === 'admin' ? (
                            <Link
                                href={`/admin/buku/${buku.id}/edit`}
                                className="inline-block rounded-xl border border-stone-300 px-8 py-3.5 text-sm font-bold text-stone-700 hover:bg-stone-100"
                            >
                                ✏️ Edit di Panel Admin
                            </Link>
                        ) : (
                            <>
                                <button
                                    type="button"
                                    onClick={pinjam}
                                    className="rounded-xl bg-emerald-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg hover:bg-emerald-700"
                                >
                                    📚 Pinjam Buku Ini
                                </button>
                                <p className="mt-2 text-sm text-stone-400">
                                    Masa peminjaman 7 hari. Tenggat dihitung sejak hari ini.
                                </p>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}
