import { useMemo, useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import GuestLayout from '../../Layouts/GuestLayout';
import BukuCard from '../../Components/BukuCard';

export default function Index({ buku, kategoriList, q = '', kategori = '', auth }) {
    const [cari, setCari] = useState(q);
    const [filterKategori, setFilterKategori] = useState(kategori);

    const hasil = useMemo(() => {
        const kata = cari.trim().toLowerCase();

        return buku.filter((item) => {
            const cocokKata =
                kata === '' ||
                [item.judul, item.penulis, item.penerbit].some((teks) =>
                    (teks ?? '').toLowerCase().includes(kata)
                );
            const cocokKategori = filterKategori === '' || item.kategori === filterKategori;

            return cocokKata && cocokKategori;
        });
    }, [buku, cari, filterKategori]);

    const adaFilter = cari.trim() !== '' || filterKategori !== '';

    return (
        <GuestLayout auth={auth}>
            <Head title="Katalog Buku" />

            <div className="mb-8">
                <h1 className="text-3xl font-black text-stone-900">Katalog Buku</h1>
                <p className="mt-1 text-stone-500">Cari judul, penulis, atau filter berdasarkan kategori.</p>
            </div>

            <div className="mb-8 rounded-2xl border border-stone-200 bg-white p-4 shadow-sm">
                <div className="flex flex-col gap-3 sm:flex-row">
                    <div className="relative flex-1">
                        <span className="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">🔍</span>
                        <input
                            type="text"
                            value={cari}
                            onChange={(e) => setCari(e.target.value)}
                            placeholder="Cari judul, penulis, atau penerbit…"
                            className="w-full rounded-xl border border-stone-300 py-3 pl-11 pr-4 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                        />
                    </div>
                    <select
                        value={filterKategori}
                        onChange={(e) => setFilterKategori(e.target.value)}
                        className="rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                    >
                        <option value="">Semua Kategori</option>
                        {kategoriList.map((kat) => (
                            <option key={kat} value={kat}>
                                {kat}
                            </option>
                        ))}
                    </select>
                    {adaFilter && (
                        <button
                            type="button"
                            onClick={() => {
                                setCari('');
                                setFilterKategori('');
                            }}
                            className="rounded-xl border border-stone-300 px-4 py-3 text-sm font-medium text-stone-600 hover:bg-stone-100"
                        >
                            Reset
                        </button>
                    )}
                </div>
                {adaFilter && (
                    <p className="mt-3 text-sm text-stone-500">
                        Menampilkan {hasil.length} buku
                        {cari.trim() !== '' && (
                            <>
                                {' '}
                                untuk pencarian "<strong>{cari}</strong>"
                            </>
                        )}
                        {filterKategori !== '' && (
                            <>
                                {' '}
                                pada kategori "<strong>{filterKategori}</strong>"
                            </>
                        )}
                    </p>
                )}
            </div>

            {hasil.length === 0 ? (
                <div className="rounded-2xl border border-dashed border-stone-300 bg-white p-16 text-center">
                    <p className="text-4xl">📖</p>
                    <p className="mt-3 font-semibold text-stone-700">Buku tidak ditemukan</p>
                    <p className="text-sm text-stone-500">Coba kata kunci lain atau ubah filter kategori.</p>
                    <Link
                        href="/buku"
                        className="mt-4 inline-block rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-emerald-700"
                    >
                        Lihat Semua Buku
                    </Link>
                </div>
            ) : (
                <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    {hasil.map((item) => (
                        <BukuCard key={item.id} buku={item} />
                    ))}
                </div>
            )}
        </GuestLayout>
    );
}
