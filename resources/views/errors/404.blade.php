@extends('layouts.app')

{{--
  ==============================================================================
  HALAMAN ERROR 404 (NOT FOUND)
  ==============================================================================
  Laravel otomatis menampilkan view ini jika terjadi HttpException dengan status 404
  (misalnya ModelNotFoundException atau abort(404)).
--}}

@section('title', '404 - Halaman Tidak Ditemukan')
@section('body_class', 'bg-zinc-950 text-zinc-100 min-h-screen antialiased flex flex-col justify-between')

@section('content')
<main class="min-h-screen flex items-center justify-center px-4 py-16 relative overflow-hidden bg-zinc-950 text-zinc-100">
    <div class="w-full max-w-lg text-center space-y-6 relative z-10">
        <!-- Kode Error 404 -->
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-zinc-900 border border-zinc-800 text-emerald-400 font-extrabold text-2xl shadow-xl">
            404
        </div>

        <div class="space-y-2">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-zinc-100 tracking-tight">
                Halaman Portofolio Tidak Ditemukan
            </h1>
            <p class="text-xs sm:text-sm text-zinc-400 leading-relaxed max-w-md mx-auto">
                Alamat URL / slug yang Anda tuju tidak terdaftar di platform kami, sudah kadaluarsa, atau masih berstatus <em>draft</em> oleh pengelola.
            </p>
        </div>

        <!-- Tombol Aksi Kembali -->
        <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
            <a href="{{ route('home') }}"
               class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-semibold shadow-lg shadow-emerald-950/60">
                &larr; Kembali ke Beranda Utama
            </a>
            <a href="https://wa.me/62895324392999?text=Halo%20Admin%20Hanan%20Aria%20Santagama,%20saya%20mencari%20halaman%20portofolio%20tetapi%20muncul%20notifikasi%20404." target="_blank"
               class="px-5 py-2.5 rounded-xl bg-zinc-900 text-zinc-300 text-xs font-semibold border border-zinc-800">
                Tanya Admin via WA
            </a>
        </div>

        <p class="text-[11px] text-zinc-600 pt-6">
            CMS Web Builder &bull; &copy; 2026 Hanan Aria Santagama | XII RPL 1
        </p>
    </div>
</main>
@endsection
