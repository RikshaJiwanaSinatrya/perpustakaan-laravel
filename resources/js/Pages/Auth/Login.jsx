import { useForm, Head, Link } from '@inertiajs/react';
import GuestLayout from '../../Layouts/GuestLayout';
import TextInput from '../../Components/TextInput';

export default function Login({ auth }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post('/login', {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout auth={auth}>
            <Head title="Masuk" />

            <div className="mx-auto max-w-md">
                <div className="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm">
                    <div className="mb-6 text-center">
                        <div className="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
                            📚
                        </div>
                        <h1 className="text-2xl font-black text-stone-900">Masuk ke Akunmu</h1>
                        <p className="mt-1 text-sm text-stone-500">
                            Belum punya akun?{' '}
                            <Link href="/register" className="font-semibold text-emerald-700 hover:underline">
                                Daftar di sini
                            </Link>
                        </p>
                    </div>

                    <form onSubmit={submit} className="space-y-4">
                        <TextInput
                            id="email"
                            type="email"
                            label="Email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            error={errors.email}
                            placeholder="nama@contoh.id"
                            autoFocus
                            required
                        />
                        <TextInput
                            id="password"
                            type="password"
                            label="Password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            error={errors.password}
                            placeholder="••••••••"
                            required
                        />
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full rounded-xl bg-emerald-600 py-3 text-sm font-bold text-white hover:bg-emerald-700 disabled:opacity-60"
                        >
                            Masuk
                        </button>
                    </form>

                    <div className="mt-6 rounded-xl bg-stone-50 p-4 text-xs text-stone-500">
                        <p className="mb-1 font-semibold text-stone-600">
                            Akun demo (password: <code className="rounded bg-stone-200 px-1">password</code>)
                        </p>
                        <p>👤 Anggota — budi@contoh.id, siti@contoh.id</p>
                        <p>🛡️ Admin — admin@perpus.id</p>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}
