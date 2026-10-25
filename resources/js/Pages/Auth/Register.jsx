import { useForm, Head, Link } from '@inertiajs/react';
import GuestLayout from '../../Layouts/GuestLayout';
import TextInput from '../../Components/TextInput';

export default function Register({ auth }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        nama: '',
        email: '',
        password: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post('/register', {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout auth={auth}>
            <Head title="Daftar Akun" />

            <div className="mx-auto max-w-md">
                <div className="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm">
                    <div className="mb-6 text-center">
                        <div className="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
                            📝
                        </div>
                        <h1 className="text-2xl font-black text-stone-900">Daftar Jadi Anggota</h1>
                        <p className="mt-1 text-sm text-stone-500">
                            Sudah punya akun?{' '}
                            <Link href="/login" className="font-semibold text-emerald-700 hover:underline">
                                Masuk di sini
                            </Link>
                        </p>
                    </div>

                    <form onSubmit={submit} className="space-y-4">
                        <TextInput
                            id="nama"
                            type="text"
                            label="Nama Lengkap"
                            value={data.nama}
                            onChange={(e) => setData('nama', e.target.value)}
                            error={errors.nama}
                            placeholder="Nama lengkap Anda"
                            autoFocus
                            required
                        />
                        <TextInput
                            id="email"
                            type="email"
                            label="Email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            error={errors.email}
                            placeholder="nama@contoh.id"
                            required
                        />
                        <TextInput
                            id="password"
                            type="password"
                            label="Password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            error={errors.password}
                            placeholder="Minimal 6 karakter"
                            required
                        />
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full rounded-xl bg-emerald-600 py-3 text-sm font-bold text-white hover:bg-emerald-700 disabled:opacity-60"
                        >
                            Daftar Sekarang
                        </button>
                    </form>

                    <p className="mt-6 text-center text-xs text-stone-400">
                        Registrasi hanya untuk demo frontend — data disimpan sementara di session browser.
                    </p>
                </div>
            </div>
        </GuestLayout>
    );
}
