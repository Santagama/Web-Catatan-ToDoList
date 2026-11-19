<?php

use App\Models\ActivityLog;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    // Admin ID 1 adalah Hanan Aria Santagama (Founder)
    $this->founder = Admin::find(1);
    if (! $this->founder) {
        $this->founder = Admin::create([
            'id' => 1,
            'name' => 'Hanan Aria Santagama',
            'username' => 'hanan',
            'password' => Hash::make('hanan123'),
        ]);
    }
});

afterEach(function () {
    // Bersihkan admin pengelola yang dibuat untuk testing
    Admin::where('username', 'like', 'test_%')
        ->orWhere('username', 'dedi_admin')
        ->delete();

    ActivityLog::where('description', 'like', '%test_%')
        ->orWhere('description', 'like', '%dedi_admin%')
        ->delete();
});

test('admin dapat melihat daftar akun admin pada halaman pengaturan', function () {
    $response = $this->actingAs($this->founder)->get(route('admin.settings.index'));

    $response->assertStatus(200);
    $response->assertSee('Kelola Akun Admin (Multi-User)');
    $response->assertSee('Admin Utama');
    $response->assertSee('@hanan');
});

test('admin dapat menambahkan akun admin pengelola baru dengan kredensial valid', function () {
    $response = $this->actingAs($this->founder)->post(route('admin.settings.admins.store'), [
        'name' => 'Dedi Kurniawan',
        'username' => 'dedi_admin',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('admin.settings.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('admins', [
        'username' => 'dedi_admin',
        'name' => 'Dedi Kurniawan',
    ]);

    // Memastikan tercatat di audit log
    $this->assertDatabaseHas('activity_logs', [
        'action' => 'TAMBAH_ADMIN',
    ]);
});

test('penambahan akun admin gagal jika username sudah terpakai atau password terlalu pendek', function () {
    // 1. Username duplikat
    $responseDuplicate = $this->actingAs($this->founder)->post(route('admin.settings.admins.store'), [
        'name' => 'Hanan Duplikat',
        'username' => 'hanan', // sudah terpakai oleh founder
        'password' => 'password123',
    ]);

    $responseDuplicate->assertSessionHasErrors('username');

    // 2. Password terlalu pendek (kurang dari 6 karakter)
    $responseShortPass = $this->actingAs($this->founder)->post(route('admin.settings.admins.store'), [
        'name' => 'Admin Baru',
        'username' => 'test_admin_short',
        'password' => '123',
    ]);

    $responseShortPass->assertSessionHasErrors('password');
});

test('proteksi anti-kudeta: admin utama founder ID 1 tidak dapat dihapus', function () {
    // Buat admin kedua
    $secondAdmin = Admin::create([
        'name' => 'Admin Penguji Dua',
        'username' => 'test_admin_two',
        'password' => 'admin123',
    ]);

    // Admin kedua mencoba menghapus Admin 1 (Founder)
    $response = $this->actingAs($secondAdmin)->delete(route('admin.settings.admins.destroy', $this->founder->id));

    $response->assertSessionHas('error');
    $this->assertDatabaseHas('admins', [
        'id' => 1,
        'username' => 'hanan',
    ]);
});

test('proteksi anti-self-delete: admin tidak dapat menghapus akunnya sendiri saat sedang login', function () {
    // Buat admin pengelola
    $admin = Admin::create([
        'name' => 'Admin Mandiri',
        'username' => 'test_admin_self',
        'password' => 'admin123',
    ]);

    // Mencoba menghapus akunnya sendiri saat aktif login
    $response = $this->actingAs($admin)->delete(route('admin.settings.admins.destroy', $admin->id));

    $response->assertSessionHas('error');
    $this->assertDatabaseHas('admins', [
        'id' => $admin->id,
        'username' => 'test_admin_self',
    ]);
});

test('admin dapat menghapus akun admin pengelola lain dan tercatat di activity log', function () {
    // Buat admin yang akan dihapus
    $targetAdmin = Admin::create([
        'name' => 'Admin Target Hapus',
        'username' => 'test_admin_target',
        'password' => 'admin123',
    ]);

    // Founder menghapus admin target
    $response = $this->actingAs($this->founder)->delete(route('admin.settings.admins.destroy', $targetAdmin->id));

    $response->assertRedirect(route('admin.settings.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('admins', [
        'id' => $targetAdmin->id,
        'username' => 'test_admin_target',
    ]);

    // Tercatat di audit log
    $this->assertDatabaseHas('activity_logs', [
        'action' => 'HAPUS_ADMIN',
    ]);
});

test('admin yang telah dihapus tidak dapat lagi melakukan login ke sistem', function () {
    $targetAdmin = Admin::create([
        'name' => 'Admin Dihapus',
        'username' => 'test_admin_deleted',
        'password' => 'password123',
    ]);

    // Hapus admin
    $this->actingAs($this->founder)->delete(route('admin.settings.admins.destroy', $targetAdmin->id));

    // Logout agar request berikutnya berstatus tamu (guest)
    $this->post(route('admin.logout'));

    // Mencoba login dengan akun yang sudah dihapus
    $response = $this->from(route('admin.login'))->post(route('admin.login.post'), [
        'username' => 'test_admin_deleted',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('username');
    $this->assertGuest();
});
