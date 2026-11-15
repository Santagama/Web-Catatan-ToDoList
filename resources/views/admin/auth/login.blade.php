@extends('layouts.app')

@section('title', 'Login Admin — CMS Web Builder')
@section('body_class', 'bg-gray-950 text-white min-h-screen antialiased')

@section('content')
<div class="relative flex min-h-screen items-center justify-center bg-gray-950 px-4 py-8">

    {{--
      Latar Belakang Video & Overlay
      Menggunakan tag <video> dengan fallback background warna gelap jika video tidak dimuat.
    --}}
    <video
        autoplay
        loop
        muted
        playsinline
        class="absolute inset-0 h-full w-full object-cover opacity-60"
    >
        <source src="/assets/login-bg.mp4" type="video/mp4" />
    </video>

    {{-- Dark Overlay semi-transparan untuk keterbacaan teks --}}
    <div class="absolute inset-0 bg-black/30"></div>

    {{-- Brand & Tombol Kembali — Pojok Kiri Atas --}}
    <div class="absolute left-4 top-4 z-20 flex flex-col items-start gap-2.5 lg:left-8 lg:top-8">
        <div>
            <h2 class="text-sm font-bold tracking-tight text-white lg:text-base">CMS Web Builder</h2>
            <p class="text-[10px] uppercase tracking-widest text-white/50">Management System</p>
        </div>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/10 px-3.5 py-2 text-xs font-semibold text-white shadow-sm"
           title="Kembali ke Halaman Web">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Web</span>
        </a>
    </div>

    {{-- Status badge — Pojok Kanan Atas --}}
    <div class="absolute right-4 top-4 z-10 lg:right-8 lg:top-8">
        <div class="flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2">
            <span class="h-2 w-2 rounded-full bg-green-400"></span>
            <span class="text-xs font-semibold text-white">Panel Admin</span>
        </div>
    </div>

    {{-- Kartu Login Utama --}}
    <div class="relative z-10 w-full max-w-md">

        {{-- Logo + Judul Platform --}}
        <div class="mb-6 text-center lg:mb-8">
            <div class="mx-auto mb-5 flex h-24 w-24 items-center justify-center overflow-hidden rounded-2xl bg-white shadow-2xl shadow-teal-500/40 lg:mb-6 lg:h-28 lg:w-28">
                <img
                    src="/assets/logo.png"
                    alt="CMS Web Builder Logo"
                    class="h-full w-full object-contain"
                    onerror="this.style.display='none'; this.nextElementSibling?.classList.remove('hidden');"
                />
                <div class="hidden text-center">
                    <div class="text-xl font-black uppercase tracking-tight text-teal-600 lg:text-2xl">CMS</div>
                    <div class="text-[10px] font-semibold uppercase tracking-wider text-teal-500 lg:text-xs">WEB</div>
                </div>
            </div>
            <h1 class="mb-1 text-2xl font-black text-white lg:text-3xl">CMS Web Builder</h1>
            <p class="text-xs font-semibold text-teal-400 lg:text-sm">Multi-Template Landing Page Platform</p>
        </div>

        {{-- Form Card --}}
        <div class="overflow-hidden rounded-2xl border border-white/20 bg-white/10 shadow-2xl shadow-black/40">

            {{-- Card Header --}}
            <div class="border-b border-white/10 bg-white/5 px-6 py-4 lg:px-7 lg:py-5">
                <h2 class="mb-1 text-lg font-bold text-white lg:text-xl">Selamat Datang!</h2>
                <p class="text-xs text-white/60 lg:text-sm">Masuk untuk mengelola website klien Anda</p>
            </div>

            {{-- Form Body --}}
            <div class="px-6 py-6 lg:px-7 lg:py-7">
                {{--
                  Form Autentikasi Admin:
                  - novalidate: Mematikan popup validasi bawaan browser agar penanganan error ditangani terpusat oleh Form Request Validator Laravel.
                  - @csrf: Token keamanan wajib Laravel untuk verifikasi sesi form.
                --}}
                <form action="{{ route('admin.login.post') }}" method="POST" id="loginForm" novalidate class="space-y-4 lg:space-y-5">
                    @csrf

                    {{-- Notifikasi Error Jika Kredensial Tidak Cocok --}}
                    @if ($errors->has('username') || $errors->has('password') || session('error'))
                        <div class="flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <p class="text-sm font-medium text-red-300">
                                {{ $errors->first('username') ?: $errors->first('password') ?: session('error') }}
                            </p>
                        </div>
                    @endif

                    {{-- Input Username --}}
                    <div>
                        <label for="username" class="mb-2 block text-xs font-bold uppercase tracking-wide text-white/70 lg:text-sm">
                            Username
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            {{-- old('username') menjaga input tetap terisi saat validasi password salah --}}
                            <input
                                id="username"
                                name="username"
                                type="text"
                                value="{{ old('username') }}"
                                placeholder="Masukkan username"
                                autocomplete="username"
                                autocapitalize="none"
                                autocorrect="off"
                                spellcheck="false"
                                required
                                autofocus
                                class="w-full rounded-xl border bg-white/10 py-3 pl-11 pr-4 text-sm text-white placeholder-white/40 outline-none lg:py-3.5 lg:text-base @error('username') border-red-500/50 @else border-white/15 @enderror"
                            />
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div>
                        <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-wide text-white/70 lg:text-sm">
                            Password
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                                class="w-full rounded-xl border bg-white/10 py-3 pl-11 pr-12 text-sm text-white placeholder-white/40 outline-none lg:py-3.5 lg:text-base @error('username') border-red-500/50 @else border-white/15 @enderror"
                            />
                            {{-- Tombol Intip Password (Show / Hide Password) --}}
                            <button
                                type="button"
                                id="togglePasswordBtn"
                                onclick="togglePasswordVisibility()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-white/40 cursor-pointer"
                                aria-label="Tampilkan password"
                            >
                                <svg id="eyeIcon" class="h-4 w-4 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Checkbox Ingat Saya (Remember Token) --}}
                    <div>
                        <label class="flex cursor-pointer items-center gap-3">
                            <div class="relative">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    value="1"
                                    {{ old('remember') ? 'checked' : '' }}
                                    class="peer sr-only"
                                />
                                <div class="h-6 w-11 rounded-full bg-white/10 ring-2 ring-white/20 peer-checked:bg-teal-500 lg:h-7 lg:w-12"></div>
                                <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-md peer-checked:translate-x-5 lg:h-5 lg:w-5 lg:peer-checked:translate-x-5"></div>
                            </div>
                            <span class="text-xs font-semibold text-white/80 lg:text-sm">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Tombol Submit Form --}}
                    <button
                        type="submit"
                        id="submitBtn"
                        class="w-full rounded-xl bg-teal-600 py-3.5 text-sm font-bold text-white lg:py-4 lg:text-base cursor-pointer flex items-center justify-center disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <span id="submitText" class="flex items-center justify-center gap-2">
                            Masuk ke Panel Admin
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </span>
                        <span id="loadingText" class="hidden items-center justify-center gap-2">
                            <span>Memproses data...</span>
                        </span>
                    </button>

                    {{-- Navigasi Bawah Form: Bantuan Lupa Password ke WA Developer --}}
                    <div class="flex items-center justify-start pt-2 text-xs">
                        <a
                            href="https://wa.me/62895324392999?text=Halo%20Developer%20Hanan%20Aria%20Santagama,%20saya:%20[SEBUT%20NAMA]%20mengalami%20kendala%20lupa%20password%20pada%20Panel%20Admin%20CMS%20Web%20Builder.%20Mohon%20izin%20bantuan%20untuk%20melakukan%20reset%20akses%20akun%20Admin%20saya.%20Terima%20kasih."
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 font-bold text-teal-400"
                        >
                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z" />
                            </svg>
                            <span>Lupa password?</span>
                        </a>
                    </div>
                </form>
            </div>

            {{-- Footer Hak Cipta --}}
            <div class="border-t border-white/10 bg-white/5 px-6 py-4 text-center lg:px-7">
                <p class="text-[10px] text-white/40 lg:text-xs">
                    &copy; 2026 Hanan Aria Santagama | XII RPL 1
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Script Interaktivitas Form --}}
<script>
    // 1. Fungsi Toggle Lihat / Sembunyikan Password
    function togglePasswordVisibility() {
        const input = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const btn = document.getElementById('togglePasswordBtn');

        if (input.type === 'password') {
            input.type = 'text';
            btn.setAttribute('aria-label', 'Sembunyikan password');
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            `;
        } else {
            input.type = 'password';
            btn.setAttribute('aria-label', 'Tampilkan password');
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            `;
        }
    }

    // 2. Mencegah Double Submit pada Tombol Masuk
    const form = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingText = document.getElementById('loadingText');

    if (form) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            loadingText.classList.remove('hidden');
            loadingText.classList.add('flex');
        });
    }

    // 3. Auto-focus ke input username saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const usernameInput = document.getElementById('username');
        if (usernameInput) {
            usernameInput.focus();
        }
    });

    // 4. Mencegah kembali ke sesi sebelumnya melalui tombol 'Back' browser
    if (window.history && window.history.pushState) {
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, null, window.location.href);
        };
    }
</script>
@endsection
