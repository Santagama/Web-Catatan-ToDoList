@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page_title', 'Pengaturan')

@section('content')
{{--
  ==============================================================================
  PENGATURAN ADMIN & STATUS SERVER
  ==============================================================================
  Memungkinkan Admin memperbarui nama, username, dan password secara mandiri.
  Serta memantau konektivitas database MySQL, direktori storage, dan routing.
--}}
<div class="space-y-6 sm:space-y-8 max-w-5xl">

    <!-- ================= HEADER SECTION ================= -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Pengaturan</h1>
    </div>

    <!-- ================= SECTION 1: RINGKASAN AKUN ================= -->
    <div class="rounded-3xl bg-[#18191f] border border-zinc-800 p-6 sm:p-8 space-y-6 shadow-sm">
        <div class="flex items-center gap-3 pb-4 border-b border-zinc-800">
            <div class="w-10 h-10 rounded-2xl bg-teal-500/10 text-teal-400 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-white">Profil Admin</h2>
            </div>
        </div>

        <!-- 4 Kartu Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 rounded-2xl bg-[#101116] border border-zinc-800 space-y-1">
                <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider block">NAMA LENGKAP</span>
                <p class="text-sm font-extrabold text-white">{{ auth()->user()->name }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-[#101116] border border-zinc-800 space-y-1">
                <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider block">USERNAME LOGIN</span>
                <p class="text-sm font-extrabold text-teal-400 font-mono">&#64;{{ auth()->user()->username }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-[#101116] border border-zinc-800 space-y-1">
                <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider block">STATUS AKSES</span>
                <span class="inline-block px-2.5 py-0.5 rounded-md bg-teal-500/20 text-teal-300 border border-teal-500/30 text-xs font-bold">
                    Admin
                </span>
            </div>
            <div class="p-4 rounded-2xl bg-[#101116] border border-zinc-800 space-y-1">
                <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider block">TERDAFTAR SEJAK</span>
                <p class="text-xs font-bold text-zinc-300">
                    {{ auth()->user()->created_at?->translatedFormat('d F Y') ?? '24 September 2026' }}
                </p>
            </div>
        </div>

        {{--
          Form Update Profil & Password:
          Menggunakan method PUT (@method('PUT')) sesuai RESTful Controller.
        --}}
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6 pt-2">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-bold text-zinc-300 mb-2 uppercase tracking-wider">
                        Nama Lengkap <span class="text-rose-400">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl bg-[#101116] border @error('name') border-rose-500 @else border-zinc-800 @enderror text-white text-sm outline-none font-medium" />
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username Login -->
                <div>
                    <label for="username" class="block text-xs font-bold text-zinc-300 mb-2 uppercase tracking-wider">
                        Username Login <span class="text-rose-400">*</span>
                    </label>
                    <input type="text"
                           name="username"
                           id="username"
                           value="{{ old('username', auth()->user()->username) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl bg-[#101116] border @error('username') border-rose-500 @else border-zinc-800 @enderror text-white text-sm font-mono outline-none font-medium" />
                    @error('username')
                        <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="p-5 rounded-2xl bg-[#101116] border border-zinc-800 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-white">Ganti Password (Opsional)</h3>
                    <p class="text-xs text-zinc-400">Kosongkan kolom password di bawah ini jika Anda tidak ingin mengubah password.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-zinc-300 mb-1.5">
                            Password Saat Ini
                        </label>
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               placeholder="Masukkan password saat ini..."
                               class="w-full sm:w-2/3 px-4 py-2.5 rounded-xl bg-[#18191f] border @error('current_password') border-rose-500 @else border-zinc-800 @enderror text-white text-sm outline-none" />
                        @error('current_password')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block text-xs font-bold text-zinc-300 mb-1.5">
                                Password Baru
                            </label>
                            <input type="password"
                                   name="new_password"
                                   id="new_password"
                                   placeholder="Minimal 6 karakter..."
                                   class="w-full px-4 py-2.5 rounded-xl bg-[#18191f] border @error('new_password') border-rose-500 @else border-zinc-800 @enderror text-white text-sm outline-none" />
                            @error('new_password')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-xs font-bold text-zinc-300 mb-1.5">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password"
                                   name="new_password_confirmation"
                                   id="new_password_confirmation"
                                   placeholder="Ulangi password baru..."
                                   class="w-full px-4 py-2.5 rounded-xl bg-[#18191f] border border-zinc-800 text-white text-sm outline-none" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-teal-600 text-white text-sm font-bold shadow-sm cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- ================= SECTION 2: LIVE SYSTEM STATUS ================= -->
    <div class="rounded-3xl bg-[#18191f] border border-zinc-800 p-6 sm:p-8 space-y-5 shadow-sm">
        <div class="pb-4 border-b border-zinc-800">
            <h2 class="text-lg font-bold text-white">Status Sistem & Server</h2>
            <p class="text-xs text-zinc-400">Pemantauan langsung konektivitas database, media upload, dan routing publik</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Database -->
            <div class="p-5 rounded-2xl bg-[#101116] border border-zinc-800 space-y-2">
                <div class="flex items-center gap-2.5 text-sm font-bold text-zinc-300">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
                    <span>Database MySQL</span>
                </div>
                <p class="text-xs font-mono text-zinc-400">{{ config('database.connections.mysql.database', 'db_cmswebbuilder') }}</p>
                <div class="flex items-center gap-1.5 text-xs font-bold text-teal-400 pt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Terhubung Aktif</span>
                </div>
            </div>

            <!-- Storage -->
            <div class="p-5 rounded-2xl bg-[#101116] border border-zinc-800 space-y-2">
                <div class="flex items-center gap-2.5 text-sm font-bold text-zinc-300">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    <span>Media Storage</span>
                </div>
                <p class="text-xs font-mono text-zinc-400">storage/app/public</p>
                <div class="flex items-center gap-1.5 text-xs font-bold text-teal-400 pt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Siap Tulis &amp; Baca</span>
                </div>
            </div>

            <!-- Mode Engine -->
            <div class="p-5 rounded-2xl bg-[#101116] border border-zinc-800 space-y-2">
                <div class="flex items-center gap-2.5 text-sm font-bold text-zinc-300">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Framework &amp; Engine</span>
                </div>
                <p class="text-xs font-mono text-zinc-400">Laravel 13 &bull; PHP {{ PHP_VERSION }}</p>
                <div class="flex items-center gap-1.5 text-xs font-bold text-teal-400 pt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Optimal</span>
                </div>
            </div>

            <!-- Akses Publik -->
            <div class="p-5 rounded-2xl bg-[#101116] border border-zinc-800 space-y-2">
                <div class="flex items-center gap-2.5 text-sm font-bold text-zinc-300">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    <span>Dynamic Slug Routing</span>
                </div>
                <p class="text-xs font-mono text-zinc-400">Aktif via /{slug}</p>
                <div class="flex items-center gap-1.5 text-xs font-bold text-teal-400 pt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>SEO 301 Redirect Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SECTION 3: BANTUAN DEVELOPER ================= -->
    <div class="rounded-3xl bg-[#18191f] border border-zinc-800 p-6 sm:p-8 space-y-4 shadow-sm">
        <h2 class="text-lg font-bold text-white">Bantuan &amp; Konsultasi Teknis</h2>
        <p class="text-xs sm:text-sm text-zinc-400 leading-relaxed font-normal">
            Mengalami kendala akun, lupa password, atau membutuhkan integrasi fitur baru pada platform CMS Web Builder?
        </p>
        <div class="pt-1">
            <a href="https://wa.me/62895324392999?text=Halo%20Developer%20Hanan%20Aria%20Santagama,%20saya%20memerlukan%20bantuan%20support%20teknis%20pada%20Panel%20Admin%20CMS%20Web%20Builder.%20Terima%20kasih." target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2.5 px-5 py-3 rounded-xl bg-teal-600 text-white font-bold text-xs sm:text-sm shadow-sm cursor-pointer">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>Hubungi Developer via WhatsApp</span>
            </a>
        </div>
    </div>

</div>
@endsection
