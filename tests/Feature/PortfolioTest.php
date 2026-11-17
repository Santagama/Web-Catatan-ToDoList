<?php

use App\Models\Admin;
use App\Models\Portfolio;

beforeEach(function () {
    $this->admin = Admin::first();
});

afterEach(function () {
    Portfolio::where('nama_umkm', 'like', '%Test%')
        ->orWhere('nama_umkm', 'like', '%Kopi Lama%')
        ->orWhere('nama_umkm', 'like', '%Usaha Rahasia%')
        ->delete();
});

test('admin dapat melihat halaman daftar portofolio', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.portfolios.index'));

    $response->assertStatus(200);
    $response->assertSee('Data Portofolio');
});

test('admin dapat membuat portofolio baru dengan format valid', function () {
    $uniqueSlug = 'warung-kopi-test-'.time();

    $response = $this->actingAs($this->admin)->post(route('admin.portfolios.store'), [
        'nama_umkm' => 'Warung Kopi Test',
        'slug' => $uniqueSlug,
        'template_id' => 'minuman',
        'bio' => 'Kedai kopi uji coba otomatis',
        'whatsapp' => '081234567890',
        'status' => 'publish',
        'paket' => '3_bulan',
    ]);

    $response->assertRedirect(route('admin.portfolios.index'));
    $this->assertDatabaseHas('portfolios', [
        'slug' => $uniqueSlug,
        'template_id' => 'minuman',
    ]);
});

test('perubahan slug mencatat riwayat dan menghasilkan redirect 301 untuk SEO', function () {
    $slugAwal = 'kopi-lama-'.time();
    $slugBaru = 'kopi-baru-'.time();

    $portfolio = Portfolio::create([
        'admin_id' => $this->admin->id,
        'template_id' => 'minuman',
        'nama_umkm' => 'Kopi Lama',
        'slug' => $slugAwal,
        'status' => 'publish',
        'paket' => 'tanpa_batas',
    ]);

    // Update slug
    $response = $this->actingAs($this->admin)->put(route('admin.portfolios.update', $portfolio), [
        'nama_umkm' => 'Kopi Lama',
        'slug' => $slugBaru,
        'template_id' => 'minuman',
        'status' => 'publish',
    ]);

    $response->assertRedirect(route('admin.portfolios.index'));

    // Periksa tabel slug_histories
    $this->assertDatabaseHas('slug_histories', [
        'portfolio_id' => $portfolio->id,
        'slug_lama' => $slugAwal,
        'slug_baru' => $slugBaru,
    ]);

    // Akses slug lama via publik -> harus dialihkan HTTP 301 ke slug baru
    $publicResponse = $this->get('/'.$slugAwal);
    $publicResponse->assertStatus(301);
    $publicResponse->assertRedirect('/'.$slugBaru);
});

test('portofolio berstatus draft tidak dapat diakses oleh publik (404)', function () {
    $slugDraft = 'usaha-rahasia-'.time();

    Portfolio::create([
        'admin_id' => $this->admin->id,
        'template_id' => 'jasa',
        'nama_umkm' => 'Usaha Rahasia',
        'slug' => $slugDraft,
        'status' => 'draft',
    ]);

    $response = $this->get('/'.$slugDraft);
    $response->assertStatus(404);
});

test('input google maps berupa tag iframe otomatis diekstrak menjadi url bersih', function () {
    $iframeTag = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.544727630577!2d108.2467472749959!3d-6.825089793172777" width="600" height="450" style="border:0;"></iframe>';
    $cleanExpected = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.544727630577!2d108.2467472749959!3d-6.825089793172777';

    $uniqueSlug = 'warung-kopi-maps-'.time();

    $this->actingAs($this->admin)->post(route('admin.portfolios.store'), [
        'nama_umkm' => 'Warung Kopi Test Maps',
        'slug' => $uniqueSlug,
        'template_id' => 'minuman',
        'maps_embed_url' => $iframeTag,
        'status' => 'publish',
    ]);

    $created = Portfolio::where('slug', $uniqueSlug)->first();
    expect($created)->not->toBeNull();
    expect($created->maps_embed_url)->toBe($cleanExpected);
});

test('admin dapat membuat portofolio dengan template barang dan publik dapat melihat katalog barang', function () {
    $uniqueSlug = 'toko-distro-test-'.time();

    $response = $this->actingAs($this->admin)->post(route('admin.portfolios.store'), [
        'nama_umkm' => 'Toko Distro Test',
        'slug' => $uniqueSlug,
        'template_id' => 'barang',
        'bio' => 'Toko busana dan pakaian retail terbaik',
        'whatsapp' => '081299998888',
        'status' => 'publish',
        'paket' => 'tanpa_batas',
    ]);

    $response->assertRedirect(route('admin.portfolios.index'));
    $this->assertDatabaseHas('portfolios', [
        'slug' => $uniqueSlug,
        'template_id' => 'barang',
    ]);

    $publicResponse = $this->get('/'.$uniqueSlug);
    $publicResponse->assertStatus(200);
    $publicResponse->assertSee('Toko Distro Test');
    $publicResponse->assertSee('Katalog Produk &amp; Barang Pilihan', false);
});
