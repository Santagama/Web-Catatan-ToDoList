<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * SettingsController (Pengontrol Halaman Pengaturan Akun Admin)
 *
 * Menangani pembaruan profil admin (nama, username)
 * dan penggantian kata sandi dengan verifikasi password lama.
 */
class SettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan akun admin.
     */
    public function index(): View
    {
        return view('admin.settings.index');
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
}
