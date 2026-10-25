import { Link } from '@inertiajs/react';
import { inisial } from '../lib/format';

export default function BukuCard({ buku }) {
    const sisa = buku.tersedia ?? 0;

    return (
        <Link
            href={`/buku/${buku.id}`}
            className="group block overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg"
        >
            <div className={`relative flex h-44 items-center justify-center bg-gradient-to-br ${buku.warna}`}>
                <span className="text-5xl font-black text-white/80">{inisial(buku.judul)}</span>
                <span className="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-0.5 text-xs font-semibold text-stone-700">
                    {buku.kategori}
                </span>
                {sisa <= 0 && (
                    <span className="absolute right-3 top-3 rounded-full bg-rose-600 px-2.5 py-0.5 text-xs font-semibold text-white">
                        Habis
                    </span>
                )}
            </div>
            <div className="space-y-1.5 p-4">
                <h3 className="line-clamp-2 font-semibold text-stone-800 group-hover:text-emerald-700">
                    {buku.judul}
                </h3>
                <p className="text-sm text-stone-500">{buku.penulis}</p>
                <div className="flex items-center justify-between pt-1 text-xs text-stone-400">
                    <span>{buku.tahun}</span>
                    <span className={`font-medium ${sisa > 0 ? 'text-emerald-600' : 'text-rose-500'}`}>
                        {sisa > 0 ? `${sisa} tersedia` : 'tidak tersedia'}
                    </span>
                </div>
            </div>
        </Link>
    );
}
