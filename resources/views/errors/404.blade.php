@extends('layouts.app')

{{--
  ==============================================================================
  HALAMAN ERROR 404 (NOT FOUND)
  ==============================================================================
  Ditampilkan otomatis oleh Laravel ketika halaman atau slug portofolio
  yang diakses pengunjung tidak ditemukan atau belum dipublikasikan.
--}}

@section('title', '404 — Halaman Tidak Ditemukan')
@section('body_class', 'bg-zinc-950 text-white min-h-screen antialiased flex flex-col justify-between')

@section('content')
<main class="min-h-screen flex items-center justify-center px-4 py-16 bg-zinc-950 text-white">
    <div class="w-full max-w-md text-center">
        {{-- Angka 404 Warna Merah Tegas --}}
        <div class="text-7xl sm:text-8xl font-black text-red-500 tracking-tighter leading-none mb-4 select-none">
            404
        </div>

        {{-- Judul & Pesan Sederhana & Clean --}}
        <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
            Halaman Tidak Ditemukan
        </h1>
        <p class="mt-3 text-sm text-zinc-400 leading-relaxed max-w-sm mx-auto">
            Alamat website yang Anda tuju tidak terdaftar, telah dipindahkan, atau belum dipublikasikan oleh pemilik usaha.
        </p>

        {{-- Tombol Aksi Sederhana --}}
        {{--
          // UBAH WARNA TOMBOL 404 KEMBALI KE BERANDA:
          // Ganti 'bg-white text-zinc-950' jadi 'bg-red-600 text-white' atau 'bg-teal-600 text-white'
        --}}
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-white hover:bg-zinc-200 px-5 py-2.5 text-xs sm:text-sm font-bold text-zinc-950 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>

            <a href="https://wa.me/62895324392999?text=Halo%20Admin%20Hanan%20Aria%20Santagama,%20saya%20mencari%20halaman%20portofolio%20tetapi%20muncul%20notifikasi%20404." 
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center gap-2 rounded-xl border border-zinc-800 bg-zinc-900/80 hover:bg-zinc-800 px-5 py-2.5 text-xs sm:text-sm font-semibold text-zinc-300 transition-colors">
                <span>Tanya Admin via WA</span>
            </a>
        </div>

        {{-- Hak Cipta --}}
        <p class="mt-14 text-xs text-zinc-600">
            &copy; {{ date('Y') }} Hanan Aria Santagama &bull; SMKN 1 Majalengka
        </p>
    </div>
</main>
@endsection
