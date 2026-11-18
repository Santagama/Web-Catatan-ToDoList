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
        <h1 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 tracking-tight">Pengaturan Sistem</h1>
    </div>

    <!-- ================= SECTION 1: RINGKASAN AKUN ================= -->
    <div class="rounded-3xl bg-white border border-zinc-200 p-6 sm:p-8 space-y-6 shadow-sm">
        <div class="flex items-center gap-3 pb-4 border-b border-zinc-200">
            <div class="w-10 h-10 rounded-2xl bg-teal-500/10 text-teal-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-zinc-900">Profil Admin</h2>
            </div>
        </div>

        <!-- 4 Kartu Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-[11px] font-bold text-zinc-500 uppercase tracking-wider block">NAMA LENGKAP</span>
                <p class="text-sm font-extrabold text-zinc-900">{{ auth()->user()->name }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-[11px] font-bold text-zinc-500 uppercase tracking-wider block">USERNAME LOGIN</span>
                <p class="text-sm font-extrabold text-zinc-900 font-mono">{{ '@' . auth()->user()->username }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-[11px] font-bold text-zinc-500 uppercase tracking-wider block">STATUS AKSES</span>
                <p class="text-sm font-extrabold text-zinc-900">Admin</p>
            </div>
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-[11px] font-bold text-zinc-500 uppercase tracking-wider block">TERDAFTAR SEJAK</span>
                <p class="text-xs font-bold text-zinc-700">
                    {{ auth()->user()->created_at?->locale('id')->translatedFormat('d F Y') ?? '24 September 2026' }}
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
                    <label for="name" class="block text-xs font-bold text-zinc-700 mb-2 uppercase tracking-wider">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl bg-zinc-50 border @error('name') border-rose-500 @else border-zinc-200 @enderror text-zinc-900 text-sm outline-none font-medium" />
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username Login -->
                <div>
                    <label for="username" class="block text-xs font-bold text-zinc-700 mb-2 uppercase tracking-wider">
                        Username Login <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="username"
                           id="username"
                           value="{{ old('username', auth()->user()->username) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl bg-zinc-50 border @error('username') border-rose-500 @else border-zinc-200 @enderror text-zinc-900 text-sm font-mono outline-none font-medium" />
                    @error('username')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-zinc-900">Ganti Password</h3>
                    <p class="text-xs text-zinc-500">Kosongkan kolom password di bawah ini jika Anda tidak ingin mengubah password.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-zinc-700 mb-1.5">
                            Password Saat Ini
                        </label>
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               placeholder="Masukkan password saat ini..."
                               class="w-full sm:w-2/3 px-4 py-2.5 rounded-xl bg-white border @error('current_password') border-rose-500 @else border-zinc-200 @enderror text-zinc-900 text-sm outline-none" />
                        @error('current_password')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block text-xs font-bold text-zinc-700 mb-1.5">
                                Password Baru
                            </label>
                            <input type="password"
                                   name="new_password"
                                   id="new_password"
                                   placeholder="Masukkan password baru..."
                                   class="w-full px-4 py-2.5 rounded-xl bg-white border @error('new_password') border-rose-500 @else border-zinc-200 @enderror text-zinc-900 text-sm outline-none" />
                            @error('new_password')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-xs font-bold text-zinc-700 mb-1.5">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password"
                                   name="new_password_confirmation"
                                   id="new_password_confirmation"
                                   placeholder="Ulangi password baru..."
                                   class="w-full px-4 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-900 text-sm outline-none" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            {{--
              // UBAH WARNA TOMBOL 'SIMPAN PROFIL':
              // Ganti 'bg-teal-600' jadi 'bg-blue-600' (biru) atau 'bg-rose-600' (merah)
            --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-teal-600 text-white text-sm font-bold shadow-sm cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- ================= SECTION 2: KELOLA AKUN ADMIN (MULTI-USER & ANTI-KUDETA) ================= -->
    <div class="rounded-3xl bg-white border border-zinc-200 p-6 sm:p-8 space-y-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-teal-500/10 text-teal-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-zinc-900">Kelola Akun Admin (Multi-User)</h2>
                    <p class="text-xs text-zinc-500">Manajemen akun pengelola CMS. Admin Utama dilindungi sistem secara permanen.</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-teal-500/10 border border-teal-500/30 text-teal-700 text-xs font-bold w-fit">
                <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                {{ $admins->count() }} Admin Terdaftar
            </span>
        </div>

        {{-- Form Tambah Admin Baru --}}
        <div class="p-5 sm:p-6 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-4">
            <div>
                <h3 class="text-sm font-bold text-zinc-900">Tambah Admin Pengelola Baru</h3>
                <p class="text-xs text-zinc-500">Buat kredensial login tambahan untuk rekan pengelola portofolio UMKM.</p>
            </div>

            <form action="{{ route('admin.settings.admins.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Nama Lengkap Admin -->
                    <div>
                        <label for="admin_name" class="block text-xs font-bold text-zinc-700 mb-1.5 uppercase tracking-wider">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="admin_name"
                               value="{{ old('name') }}"
                               placeholder="Masukkan nama lengkap..."
                               required
                               class="w-full px-4 py-2.5 rounded-xl bg-white border @error('name') border-rose-500 @else border-zinc-200 @enderror text-zinc-900 text-sm outline-none font-medium" />
                        @error('name')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username Login -->
                    <div>
                        <label for="admin_username" class="block text-xs font-bold text-zinc-700 mb-1.5 uppercase tracking-wider">
                            Username Login <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="username"
                               id="admin_username"
                               value="{{ old('username') }}"
                               placeholder="Masukkan username..."
                               required
                               class="w-full px-4 py-2.5 rounded-xl bg-white border @error('username') border-rose-500 @else border-zinc-200 @enderror text-zinc-900 text-sm font-mono outline-none font-medium" />
                        @error('username')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label for="admin_password" class="block text-xs font-bold text-zinc-700 mb-1.5 uppercase tracking-wider">
                            Password <span class="text-rose-500">*</span>
                        </label>
                        <input type="password"
                               name="password"
                               id="admin_password"
                               placeholder="Masukkan password..."
                               required
                               class="w-full px-4 py-2.5 rounded-xl bg-white border @error('password') border-rose-500 @else border-zinc-200 @enderror text-zinc-900 text-sm outline-none" />
                        @error('password')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{--
                  // UBAH WARNA TOMBOL 'DAFTARKAN ADMIN BARU':
                  // Ganti 'bg-teal-600' jadi 'bg-blue-600' (biru) atau 'bg-indigo-600' (ungu)
                --}}
                <div class="flex justify-end pt-1">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-600 text-white text-xs sm:text-sm font-bold shadow-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        <span>Tambah Akun Admin</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Daftar Seluruh Admin --}}
        <div class="space-y-3">
            <h3 class="text-sm font-bold text-zinc-900">Daftar Admin Aktif</h3>

            <div class="overflow-x-auto rounded-2xl border border-zinc-200 bg-zinc-50">
                <table class="w-full text-left text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 text-[11px] font-bold text-zinc-500 uppercase tracking-wider bg-zinc-100">
                            <th class="py-3.5 px-4 text-center w-12">No</th>
                            <th class="py-3.5 px-4">Nama Pengelola</th>
                            <th class="py-3.5 px-4">Username</th>
                            <th class="py-3.5 px-4">Peran / Hak Akses</th>
                            <th class="py-3.5 px-4">Terdaftar</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200">
                        @foreach ($admins as $index => $item)
                            <tr class="bg-white">
                                <!-- Nomor -->
                                <td class="py-3.5 px-4 text-center text-zinc-500 font-bold">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Nama & Avatar -->
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full {{ $item->id === 1 ? 'bg-teal-500/20 text-teal-700 border border-teal-500/40' : 'bg-zinc-100 text-zinc-600' }} flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-zinc-900">{{ $item->name }}</p>
                                            @if ($item->id === auth()->id())
                                                <span class="text-[10px] text-teal-600 font-semibold">(Sedang Anda Gunakan)</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Username -->
                                <td class="py-3.5 px-4 font-mono text-zinc-700">
                                    {{ '@' . $item->username }}
                                </td>

                                <!-- Peran / Hak Akses -->
                                <td class="py-3.5 px-4">
                                    @if ($item->id === 1)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-teal-500/15 border border-teal-500/30 text-teal-700 text-xs font-bold">
                                            <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                            Admin Utama
                                        </span>
                                    @elseif ($item->id === auth()->id())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-cyan-500/15 border border-cyan-500/30 text-cyan-700 text-xs font-bold">
                                            Admin Aktif (Anda)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-zinc-100 text-zinc-600 border border-zinc-200 text-xs font-semibold">
                                            Admin Pengelola
                                        </span>
                                    @endif
                                </td>

                                <!-- Terdaftar -->
                                <td class="py-3.5 px-4 text-xs text-zinc-500">
                                    {{ $item->created_at?->translatedFormat('d M Y') ?? '12 Nov 2026' }}
                                </td>

                                <!-- Aksi -->
                                <td class="py-3.5 px-4 text-right">
                                    @if ($item->id === 1)
                                        {{-- Admin Utama Dilindungi Secara Permanen (Anti-Kudeta) --}}
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-zinc-100 border border-zinc-200 text-zinc-500 text-xs font-semibold cursor-not-allowed" title="Admin Utama dilindungi sistem dan tidak dapat dihapus">
                                            <svg class="w-3.5 h-3.5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            Dilindungi
                                        </span>
                                    @elseif ($item->id === auth()->id())
                                        {{-- Mencegah Hapus Diri Sendiri Saat Sedang Login --}}
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-zinc-100 border border-zinc-200 text-zinc-400 text-xs font-semibold cursor-not-allowed" title="Anda tidak dapat menghapus akun yang sedang Anda gunakan">
                                            Akun Anda
                                        </span>
                                    @else
                                        {{-- Form Hapus Admin Biasa --}}
                                        <form action="{{ route('admin.settings.admins.destroy', $item->id) }}" method="POST" class="inline-block"

                                              {{-- // TEMPAT KODE POPUP KONFIRMASI HAPUS ADMIN DI SINI // --}}

                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 text-xs font-bold cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================= SECTION 3: LIVE SYSTEM STATUS ================= -->
    <div class="rounded-3xl bg-white border border-zinc-200 p-6 sm:p-8 space-y-5 shadow-sm">
        <div class="pb-4 border-b border-zinc-200">
            <h2 class="text-lg font-bold text-zinc-900">Status Sistem & Server</h2>
            <p class="text-xs text-zinc-500">Pemantauan langsung konektivitas database, media upload, dan routing publik</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Database -->
            <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-2">
                <div class="flex items-center gap-2.5 text-sm font-bold text-zinc-700">
                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
                    <span>Database MySQL</span>
                </div>
                <p class="text-xs font-mono text-zinc-500">{{ config('database.connections.mysql.database', 'db_cmswebbuilder') }}</p>
            </div>

            <!-- Storage -->
            <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-2">
                <div class="flex items-center gap-2.5 text-sm font-bold text-zinc-700">
                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    <span>Media Storage</span>
                </div>
                <p class="text-xs font-mono text-zinc-500">storage/app/public</p>
            </div>

            <!-- Mode Engine -->
            <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-2">
                <div class="flex items-center gap-2.5 text-sm font-bold text-zinc-700">
                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Framework &amp; Engine</span>
                </div>
                <p class="text-xs font-mono text-zinc-500">Laravel 13 &bull; PHP {{ PHP_VERSION }}</p>
            </div>

            <!-- Akses Publik -->
            <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-2">
                <div class="flex items-center gap-2.5 text-sm font-bold text-zinc-700">
                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    <span>Dynamic Slug Routing</span>
                </div>
                <p class="text-xs font-mono text-zinc-500">Aktif via /{slug}</p>
            </div>
        </div>
    </div>

    <!-- ================= SECTION 4: BANTUAN DEVELOPER ================= -->
    <div class="rounded-3xl bg-white border border-zinc-200 p-6 sm:p-8 space-y-4 shadow-sm">
        <h2 class="text-lg font-bold text-zinc-900">Bantuan &amp; Konsultasi Teknis</h2>
        <p class="text-xs sm:text-sm text-zinc-500 leading-relaxed font-normal">
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
