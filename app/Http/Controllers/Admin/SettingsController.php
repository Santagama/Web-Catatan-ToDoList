<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * SettingsController (Pengontrol Halaman Pengaturan Akun Admin)
 *
 * Menangani:
 * 1. Pembaruan profil admin aktif (nama, username, kata sandi)
 * 2. CRUD manajemen multi-user akun Admin (Tambah, Tampil, Hapus)
 *    dilengkapi proteksi Anti-Kudeta untuk Admin Utama (ID 1)
 *    dan proteksi Anti-Self Delete.
 */
class SettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan akun admin dan daftar akun admin terdaftar.
     */
    public function index(): View
    {
        // Mengambil seluruh data admin diurutkan dari akun pertama (Founder)
        $admins = Admin::oldest('id')->get();

        return view('admin.settings.index', compact('admins'));
    }

    /**
     * Memproses pembaruan data profil dan/atau kata sandi admin.
     */
    public function update(Request $request): RedirectResponse
    {
        $admin = auth()->user();

        // 1. Validasi input profil
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:5', 'max:50', 'unique:admins,username,'.$admin->id],
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 5 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengganti password.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // 2. Jika admin ingin mengganti kata sandi
        if ($request->filled('new_password')) {
            // Verifikasi kata sandi lama terlebih dahulu
            if (! Hash::check($request->input('current_password'), $admin->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.',
                ]);
            }

            // Update password baru (otomatis di-hash via Model $casts)
            $admin->password = $validated['new_password'];
        }

        // 3. Update profil nama dan username
        $admin->name = $validated['name'];
        $admin->username = $validated['username'];
        $admin->save();

        // 4. Catat jejak audit
        ActivityLog::record(
            'GANTI_PENGATURAN',
            'Admin '.$admin->name.' memperbarui pengaturan profil/password.'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan akun berhasil disimpan!');
    }

    /**
     * Menambahkan akun admin pengelola baru ke sistem.
     */
    public function storeAdmin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:4', 'max:50', 'alpha_dash', 'unique:admins,username'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'Nama lengkap admin wajib diisi.',
            'username.required' => 'Username login wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.alpha_dash' => 'Username hanya boleh berupa huruf, angka, tanda strip (-), atau garis bawah (_).',
            'username.unique' => 'Username tersebut sudah terdaftar pada sistem.',
            'password.required' => 'Password akun admin wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $newAdmin = Admin::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'password' => $validated['password'], // Otomatis di-hash via Model casts
        ]);

        ActivityLog::record(
            'TAMBAH_ADMIN',
            'Menambahkan akun admin baru: '.$newAdmin->name.' (@'.$newAdmin->username.')'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Akun admin baru "'.$newAdmin->name.'" (@'.$newAdmin->username.') berhasil ditambahkan!');
    }

    /**
     * Menghapus akun admin tertentu dari sistem.
     *
     * Dilengkapi 2 lapis proteksi keamanan:
     * 1. Anti-Kudeta: Admin ID 1 (Founder/Primary Admin) terlindungi secara permanen dari penghapusan.
     * 2. Anti-Self Delete: Admin tidak diizinkan menghapus akun miliknya sendiri saat sesi login aktif.
     */
    public function destroyAdmin(Admin $admin): RedirectResponse
    {
        // Proteksi 1: Anti-Kudeta (Admin Utama ID 1 dilindungi)
        if ($admin->id === 1) {
            return back()->with('error', 'Akun Admin Utama (Founder) dilindungi secara permanen dan tidak dapat dihapus oleh siapapun!');
        }

        // Proteksi 2: Anti-Self Delete (Mencegah admin menghapus dirinya sendiri)
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang aktif masuk!');
        }

        $deletedName = $admin->name;
        $deletedUsername = $admin->username;
        $admin->delete();

        ActivityLog::record(
            'HAPUS_ADMIN',
            'Menghapus akun admin: '.$deletedName.' (@'.$deletedUsername.')'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Akun admin "'.$deletedName.'" (@'.$deletedUsername.') berhasil dihapus dari sistem!');
    }
}
