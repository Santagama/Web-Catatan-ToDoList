<?php

use App\Models\Admin;
use Illuminate\Support\Facades\RateLimiter;

test('tamu tidak bisa mengakses dashboard dan diarahkan ke login', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
});

test('admin dapat login dengan kredensial yang benar', function () {
    RateLimiter::clear('hanan|127.0.0.1');

    $response = $this->post(route('admin.login.post'), [
        'username' => 'hanan',
        'password' => 'hanan123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticated();
});

test('admin gagal login dengan password salah dan menampilkan error', function () {
    $response = $this->from(route('admin.login'))->post(route('admin.login.post'), [
        'username' => 'hanan',
        'password' => 'password-salah-123',
    ]);

    $response->assertRedirect(route('admin.login'));
    $response->assertSessionHasErrors('username');
    $this->assertGuest();
});

test('admin dapat logout dan sesi dibersihkan', function () {
    $admin = Admin::first();
    $this->actingAs($admin);

    $this->assertAuthenticated();

    $response = $this->post(route('admin.logout'));

    $response->assertRedirect(route('admin.login'));
    $this->assertGuest();
});

test('respon halaman web memuat header anti cache back button', function () {
    $response = $this->get(route('admin.login'));

    $cacheControl = $response->headers->get('Cache-Control');
    expect($cacheControl)->toContain('no-store');
    expect($cacheControl)->toContain('no-cache');
    expect($cacheControl)->toContain('must-revalidate');
    $response->assertHeader('Pragma', 'no-cache');
});
