<?php

namespace App\Http\Controllers\Admin;

// Mengimpor class dasar Controller, model ActivityLog & Admin, dan fasilitas Hash Laravel
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * SettingsController (Pengontrol Pengaturan Akun Admin & Multi-User)
 *
 * Menangani:
 * 1. Pembaruan profil admin yang sedang login (Nama, Username, dan Ganti Password).
 * 2. Tambah akun admin baru untuk kolaborasi tim pengelola.
 * 3. Hapus akun admin dengan 2 lapis keamanan tingkat tinggi:
 *    - Proteksi Anti-Kudeta: Akun Admin Utama (ID 1 / Hanan) tidak bisa dihapus oleh siapapun!
 *    - Proteksi Anti-Self Delete: Admin tidak bisa menghapus akun miliknya sendiri yang sedang login.
 */
class SettingsController extends Controller
{
    /**
     * 1. Menampilkan halaman form pengaturan profil dan daftar seluruh akun admin terdaftar.
     */
    public function index(): View
    {
        // Ambil semua data akun admin diurutkan dari akun pertama kali dibuat (Founder)
        $admins = Admin::oldest('id')->get();

        return view('admin.settings.index', compact('admins'));
    }

    /**
     * 2. Memproses pembaruan data profil dan ganti kata sandi admin yang sedang login.
     */
    public function update(Request $request): RedirectResponse
    {
        // Ambil data admin yang sedang aktif login saat ini
        $admin = auth()->user();

        // LANGKAH 1: VALIDASI INPUT PROFIL & PASSWORD
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:5', 'max:50', 'unique:admins,username,'.$admin->id],
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 5 karakter.',
            'username.unique' => 'Username sudah digunakan admin lain.',
            'current_password.required_with' => 'Password saat ini wajib diisi jika ingin mengganti password.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // LANGKAH 2: JIKA ADMIN INGIN MENGGANTI PASSWORD
        if ($request->filled('new_password')) {
            // Verifikasi kecocokan password lama dengan hash yang tersimpan di database
            if (! Hash::check($request->input('current_password'), $admin->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.',
                ]);
            }

            // Ganti password (otomatis dienkripsi hash Bcrypt lewat Model casts)
            $admin->password = $validated['new_password'];
        }

        // LANGKAH 3: UPDATE DATA NAMA DAN USERNAME
        $admin->name = $validated['name'];
        $admin->username = $validated['username'];
        $admin->save();

        // LANGKAH 4: CATAT KE LOG AKTIVITAS
        ActivityLog::record(
            'GANTI_PENGATURAN',
            'Admin '.$admin->name.' memperbarui pengaturan profil/password.'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan akun berhasil disimpan!');
    }

    /**
     * 3. Menambahkan akun admin pengelola baru ke dalam sistem.
     */
    public function storeAdmin(Request $request): RedirectResponse
    {
        // Validasi input akun baru
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:4', 'max:50', 'alpha_dash', 'unique:admins,username'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'Nama lengkap admin wajib diisi.',
            'username.required' => 'Username login wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.alpha_dash' => 'Username hanya boleh berupa huruf, angka, strip, dan underscore.',
            'username.unique' => 'Username tersebut sudah digunakan oleh akun lain.',
            'password.required' => 'Password akun admin wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // Simpan data admin baru ke tabel admins
        $newAdmin = Admin::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'password' => $validated['password'], // Otomatis di-hash oleh model
        ]);

        // Catat ke log aktivitas
        ActivityLog::record(
            'TAMBAH_ADMIN',
            'Menambahkan akun admin baru: '.$newAdmin->name.' (@'.$newAdmin->username.')'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Akun admin baru "'.$newAdmin->name.'" (@'.$newAdmin->username.') berhasil ditambahkan!');
    }

    /**
     * 4. Menghapus akun admin tertentu dari sistem (dengan 2 Lapis Proteksi).
     */
    public function destroyAdmin(Admin $admin): RedirectResponse
    {
        // LAPIS PROTEKSI 1: ANTI-KUDETA
        // Akun Admin ID 1 (Founder / Hanan Aria Santagama) dilindungi selamanya dan tidak boleh dihapus!
        if ($admin->id === 1) {
            return back()->with('error', 'Akun Admin Utama (Founder) dilindungi secara permanen dan tidak dapat dihapus oleh siapapun!');
        }

        // LAPIS PROTEKSI 2: ANTI-SELF DELETE
        // Admin dilarang menghapus akun dirinya sendiri saat sedang aktif login
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang aktif masuk!');
        }

        $deletedName = $admin->name;
        $deletedUsername = $admin->username;

        // Hapus akun dari database
        $admin->delete();

        // Catat ke log aktivitas
        ActivityLog::record(
            'HAPUS_ADMIN',
            'Menghapus akun admin: '.$deletedName.' (@'.$deletedUsername.')'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Akun admin "'.$deletedName.'" (@'.$deletedUsername.') berhasil dihapus dari sistem!');
    }
}
