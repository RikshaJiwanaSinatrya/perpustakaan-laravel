const BULAN = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

export function formatTanggal(tanggal) {
    if (!tanggal) return '-';

    const d = new Date(`${tanggal}T00:00:00`);
    if (Number.isNaN(d.getTime())) return tanggal;

    return `${d.getDate()} ${BULAN[d.getMonth()]} ${d.getFullYear()}`;
}

export function labelStatus(status) {
    return (
        {
            dipinjam: 'Dipinjam',
            dikembalikan: 'Dikembalikan',
            terlambat: 'Terlambat',
        }[status] ?? status
    );
}

export function classStatus(status) {
    return (
        {
            dipinjam: 'bg-sky-100 text-sky-700',
            dikembalikan: 'bg-emerald-100 text-emerald-700',
            terlambat: 'bg-rose-100 text-rose-700',
        }[status] ?? 'bg-stone-100 text-stone-700'
    );
}

export function inisial(teks) {
    return (teks ?? '?').charAt(0).toUpperCase();
}
