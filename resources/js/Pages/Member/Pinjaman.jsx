import { Head, Link, router } from '@inertiajs/react';
import GuestLayout from '../../Layouts/GuestLayout';
import StatusBadge from '../../Components/StatusBadge';
import { formatTanggal, inisial } from '../../lib/format';

export default function Pinjaman({ pinjaman, auth }) {
    const user = auth?.user ?? null;

    const kembalikan = (loan) => {
        if (confirm(`Kembalikan buku "${loan.buku?.judul}"?`)) {
            router.post(`/pinjaman/${loan.id}/kembali`);
        }
    };

    return (
        <GuestLayout auth={auth}>
            <Head title="Pinjaman Saya" />

            <div className="mb-8 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h1 className="text-3xl font-black text-stone-900">Pinjaman Saya</h1>
                    <p className="mt-1 text-stone-500">
                        Halo {user?.nama} — no. anggota {user?.no_anggota}
                    </p>
                </div>
                <Link
                    href="/buku"
                    className="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-emerald-700"
                >
                    + Pinjam Buku Lain
                </Link>
            </div>

            {pinjaman.length === 0 ? (
                <div className="rounded-2xl border border-dashed border-stone-300 bg-white p-16 text-center">
                    <p className="text-4xl">📭</p>
                    <p className="mt-3 font-semibold text-stone-700">Belum ada peminjaman</p>
                    <p className="text-sm text-stone-500">Yuk mulai pinjam buku dari katalog.</p>
                    <Link
                        href="/buku"
                        className="mt-4 inline-block rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-emerald-700"
                    >
                        Buka Katalog
                    </Link>
                </div>
            ) : (
                <div className="space-y-4">
                    {pinjaman.map((loan) => {
                        const buku = loan.buku;

                        return (
                            <div
                                key={loan.id}
                                className="flex flex-col gap-4 rounded-2xl border border-stone-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center"
                            >
                                <div
                                    className={`flex h-20 w-16 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br ${
                                        buku?.warna ?? 'from-stone-400 to-stone-600'
                                    } text-2xl font-black text-white/80`}
                                >
                                    {inisial(buku?.judul)}
                                </div>
                                <div className="min-w-0 flex-1">
                                    <Link
                                        href={`/buku/${loan.buku_id}`}
                                        className="font-bold text-stone-900 hover:text-emerald-700"
                                    >
                                        {buku?.judul ?? '(buku dihapus)'}
                                    </Link>
                                    <p className="text-sm text-stone-500">
                                        {buku?.penulis} · {buku?.kategori}
                                    </p>
                                    <p className="mt-1 text-xs text-stone-400">
                                        Dipinjam {formatTanggal(loan.tanggal_pinjam)} — Kembali{' '}
                                        {formatTanggal(loan.tanggal_kembali)}
                                    </p>
                                </div>
                                <div className="flex items-center gap-3">
                                    <StatusBadge status={loan.status} />
                                    {loan.status === 'dipinjam' && (
                                        <button
                                            type="button"
                                            onClick={() => kembalikan(loan)}
                                            className="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700"
                                        >
                                            Kembalikan
                                        </button>
                                    )}
                                </div>
                            </div>
                        );
                    })}
                </div>
            )}
        </GuestLayout>
    );
}
