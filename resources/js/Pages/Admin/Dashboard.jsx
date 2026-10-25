import { Head, Link } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import StatusBadge from '../../Components/StatusBadge';
import { formatTanggal } from '../../lib/format';

export default function Dashboard({
    totalJudul,
    totalKopi,
    totalAnggota,
    dipinjam,
    terlambat,
    dikembalikan,
    terbaru,
    kategoriStats,
    auth,
}) {
    const hariIni = formatTanggal(new Date().toISOString().slice(0, 10));

    const cards = [
        { label: 'Judul Buku', nilai: totalJudul, ikon: '📖', bg: 'from-emerald-50 to-white', warna: 'text-emerald-700' },
        { label: 'Eksemplar', nilai: totalKopi, ikon: '📚', bg: 'from-sky-50 to-white', warna: 'text-sky-700' },
        { label: 'Anggota', nilai: totalAnggota, ikon: '👥', bg: 'from-violet-50 to-white', warna: 'text-violet-700' },
        { label: 'Sedang Dipinjam', nilai: dipinjam, ikon: '🔄', bg: 'from-amber-50 to-white', warna: 'text-amber-700' },
    ];

    return (
        <AdminLayout auth={auth} title="Dashboard Admin">
            <Head title="Dashboard Admin" />

            <div className="mb-8">
                <h2 className="text-2xl font-black text-stone-900">Ringkasan Perpustakaan</h2>
                <p className="text-sm text-stone-500">Statistik peminjaman dan koleksi hari ini, {hariIni}.</p>
            </div>

            <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                {cards.map((card) => (
                    <div
                        key={card.label}
                        className={`rounded-2xl border border-stone-200 bg-gradient-to-br ${card.bg} p-5 shadow-sm`}
                    >
                        <div className="flex items-center justify-between">
                            <p className="text-sm font-medium text-stone-500">{card.label}</p>
                            <span className="text-xl">{card.ikon}</span>
                        </div>
                        <p className={`mt-2 text-3xl font-black ${card.warna}`}>{card.nilai}</p>
                    </div>
                ))}
            </div>

            <div className="mt-6 grid gap-4 lg:grid-cols-3">
                <div className="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    <p className="text-sm font-medium text-stone-500">Kategori Koleksi</p>
                    <p className="mt-2 text-2xl font-black text-stone-900">{kategoriStats}</p>
                </div>
                <div className="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    <p className="text-sm font-medium text-stone-500">Sudah Dikembalikan</p>
                    <p className="mt-2 text-2xl font-black text-emerald-600">{dikembalikan}</p>
                </div>
                <div className="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    <p className="text-sm font-medium text-stone-500">Terlambat</p>
                    <p className="mt-2 text-2xl font-black text-rose-600">{terlambat}</p>
                </div>
            </div>

            <div className="mt-8 overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div className="flex items-center justify-between border-b border-stone-200 px-5 py-4">
                    <h3 className="font-bold text-stone-900">Peminjaman Terbaru</h3>
                    <Link href="/admin/peminjaman" className="text-sm font-semibold text-emerald-700 hover:underline">
                        Lihat semua →
                    </Link>
                </div>
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-sm">
                        <thead className="bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                            <tr>
                                <th className="px-5 py-3">Buku</th>
                                <th className="px-5 py-3">Anggota</th>
                                <th className="px-5 py-3">Pinjam</th>
                                <th className="px-5 py-3">Kembali</th>
                                <th className="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-stone-100">
                            {terbaru.length === 0 ? (
                                <tr>
                                    <td colSpan="5" className="px-5 py-10 text-center text-stone-400">
                                        Belum ada peminjaman.
                                    </td>
                                </tr>
                            ) : (
                                terbaru.map((loan) => (
                                    <tr key={loan.id} className="hover:bg-stone-50">
                                        <td className="px-5 py-3 font-medium text-stone-800">
                                            {loan.buku?.judul ?? '(dihapus)'}
                                        </td>
                                        <td className="px-5 py-3">{loan.anggota?.nama ?? '-'}</td>
                                        <td className="px-5 py-3 text-stone-500">{formatTanggal(loan.tanggal_pinjam)}</td>
                                        <td className="px-5 py-3 text-stone-500">{formatTanggal(loan.tanggal_kembali)}</td>
                                        <td className="px-5 py-3">
                                            <StatusBadge status={loan.status} />
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
