<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registrasi khusus akun Siswa baru
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nis'      => 'required|string|max:30|unique:users,nis',
            'kelas'    => 'required|string|max:50',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // Butuh field password_confirmation
        ], [
            'nis.required'       => 'NIS wajib diisi untuk siswa.',
            'nis.unique'         => 'NIS sudah terdaftar.',
            'kelas.required'     => 'Kelas wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'nis'      => $validated['nis'],
            'kelas'    => $validated['kelas'],
            'email'    => $validated['email'],
            'role'     => 'siswa', // Default otomatis menjadi siswa
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi siswa berhasil',
            'data'    => $user
        ], 201);
    }

    /**
     * Login untuk semua role (Admin, Petugas, Siswa)
     * Bisa login menggunakan Email atau NIS
     */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string', // Bisa diisi email atau NIS
            'password' => 'required|string',
        ]);

        // Deteksi apakah input berupa email atau NIS
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email/NIS atau password salah.'
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data'    => Auth::user()
        ], 200);
    }

    /**
     * Mengambil data profil user yang sedang login saat ini
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data'    => $request->user()
        ], 200);
    }

    /**
     * Logout dan hapus sesi
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ], 200);
    }

    /**
     * Mengambil daftar seluruh siswa (Untuk dropdown peminjaman oleh Admin/Petugas)
     */
    public function listSiswa()
    {
        $siswa = User::where('role', 'siswa')
            ->select('id', 'name', 'nis', 'kelas', 'email')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar siswa berhasil diambil',
            'data'    => $siswa
        ], 200);
    }
}