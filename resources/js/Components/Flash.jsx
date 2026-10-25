import { usePage } from '@inertiajs/react';

export default function Flash() {
    const { flash, errors } = usePage().props;
    const daftarError = errors ? Object.values(errors) : [];

    return (
        <>
            {flash?.sukses && (
                <div className="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {flash.sukses}
                </div>
            )}

            {flash?.galat && (
                <div className="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                    {flash.galat}
                </div>
            )}

            {daftarError.length > 0 && (
                <div className="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                    <ul className="list-inside list-disc space-y-0.5">
                        {daftarError.map((pesan, i) => (
                            <li key={i}>{pesan}</li>
                        ))}
                    </ul>
                </div>
            )}
        </>
    );
}
