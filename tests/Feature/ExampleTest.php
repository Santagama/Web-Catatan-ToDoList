<?php

test('halaman utama landing page menampilkan cms web builder dan identitas developer', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('CMS Web Builder');
    $response->assertSee('Hanan Aria Santagama');
    $response->assertSee('XII RPL 1');
});

test('halaman login admin dapat diakses', function () {
    $response = $this->get(route('admin.login'));

    $response->assertStatus(200);
    $response->assertSee('Login Admin');
});

test('slug yang tidak terdaftar menghasilkan response 404', function () {
    $response = $this->get('/slug-yang-tidak-pernah-ada-12345');

    $response->assertStatus(404);
    $response->assertSee('Halaman Tidak Ditemukan');
});
