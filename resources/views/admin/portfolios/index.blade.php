@extends('layouts.admin')

@section('title', 'Direktori Web Klien — Data Portofolio')
@section('page_title', 'Direktori Web Klien')

@section('content')
{{--
  ==============================================================================
  DIREKTORI WEBSITE PORTOFOLIO KLIEN
  ==============================================================================
  Menyajikan tabel master data portofolio UMKM dengan pencarian, filter status,
  preview link publik, edit, dan hapus data.
--}}
<div class="space-y-6 sm:space-y-8">

    <!-- ================= HEADER SECTION & TAB SWITCHER ================= -->
    <div class="space-y-5">
        <div>
            <span class="sr-only">Data Portofolio</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Direktori Web Klien</h1>
            <p class="text-xs sm:text-sm text-zinc-400 mt-1 font-medium">
                {{ $totalCount ?? $portfolios->total() }} website terdaftar &bull; {{ $publishCount ?? 0 }} publish &bull; {{ $draftCount ?? 0 }} draft
            </p>
        </div>

        <!-- Tab Switcher (Daftar Website / Buat Web Baru) -->
        <div class="grid grid-cols-2 p-1.5 rounded-2xl bg-[#101116] border border-zinc-800 gap-1.5">
            <a href="{{ route('admin.portfolios.index') }}"
               class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-teal-500/15 text-teal-300 border border-teal-500/30 text-xs sm:text-sm font-bold shadow-xs">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                <span>Daftar Website</span>
                <span class="px-2 py-0.5 rounded-full bg-teal-400/20 text-teal-300 text-xs font-extrabold">{{ $totalCount ?? $portfolios->total() }}</span>
            </a>
            <a href="{{ route('admin.portfolios.create') }}"
               class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-zinc-400 text-xs sm:text-sm font-bold">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                <span>Buat Web Baru</span>
            </a>
        </div>
    </div>

    <!-- ================= BAR PENCARIAN & FILTER PILL ================= -->
    <div class="p-4 sm:p-5 rounded-2xl bg-[#18191f] border border-zinc-800 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        {{--
          Form Pencarian:
          Mempertahankan parameter 'status' jika ada filter status aktif, agar pencarian berjalan di dalam filter tersebut.
        --}}
        <form action="{{ route('admin.portfolios.index') }}" method="GET" class="flex-1 max-w-lg">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama web atau slug..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-[#101116] border border-zinc-800 text-white placeholder-zinc-500 text-xs sm:text-sm outline-none" />
            </div>
        </form>

        <!-- Filter Status Pills -->
        @php
            $currentStatus = request('status', '');
        @endphp
        <div class="flex flex-wrap items-center gap-1.5 self-start md:self-center">
            <a href="{{ route('admin.portfolios.index', request()->only('search')) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-bold {{ $currentStatus === '' ? 'bg-teal-600 text-white' : 'bg-zinc-900 text-zinc-400 border border-zinc-800' }}">
                Semua ({{ $totalCount ?? 0 }})
            </a>
            <a href="{{ route('admin.portfolios.index', array_merge(request()->only('search'), ['status' => 'publish'])) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-bold {{ $currentStatus === 'publish' ? 'bg-teal-600 text-white' : 'bg-zinc-900 text-zinc-400 border border-zinc-800' }}">
                Publish ({{ $publishCount ?? 0 }})
            </a>
            <a href="{{ route('admin.portfolios.index', array_merge(request()->only('search'), ['status' => 'draft'])) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-bold {{ $currentStatus === 'draft' ? 'bg-teal-600 text-white' : 'bg-zinc-900 text-zinc-400 border border-zinc-800' }}">
                Draft ({{ $draftCount ?? 0 }})
            </a>
        </div>
    </div>

    <!-- ================= TABEL DATA KLIEN ================= -->
    <div class="bg-[#18191f] border border-zinc-800 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-zinc-400 border-b border-zinc-800 text-xs uppercase tracking-wider bg-[#101116]">
                        <th class="px-5 py-4 font-bold">Logo</th>
                        <th class="px-5 py-4 font-bold">Nama Web</th>
                        <th class="px-5 py-4 font-bold">Slug</th>
                        <th class="px-5 py-4 font-bold">Template</th>
                        <th class="px-5 py-4 font-bold">Status</th>
                        <th class="px-5 py-4 font-bold">Expired</th>
                        <th class="px-5 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60">
                    @forelse ($portfolios as $porto)
                        <tr>
                            <!-- Kolom: Logo (Storage::url membaca symlink public/storage) -->
                            <td class="px-5 py-4">
                                <div class="w-10 h-10 rounded-xl bg-zinc-900 border border-zinc-800 p-1 flex items-center justify-center overflow-hidden shrink-0">
                                    @if ($porto->logo_path)
                                        <img src="{{ Storage::url($porto->logo_path) }}" alt="{{ $porto->nama_umkm }}" class="w-full h-full object-contain rounded-lg" />
                                    @else
                                        <span class="text-teal-400 font-bold text-xs uppercase">{{ substr($porto->nama_umkm, 0, 2) }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kolom: Nama Web & Bio -->
                            <td class="px-5 py-4">
                                <p class="font-bold text-white text-sm sm:text-base">{{ $porto->nama_umkm }}</p>
                                <p class="text-xs text-zinc-400 mt-0.5 line-clamp-1">{{ $porto->bio ?? 'Tidak ada deskripsi' }}</p>
                            </td>

                            <!-- Kolom: Slug (URL Bersih) -->
                            <td class="px-5 py-4 font-mono text-xs text-teal-400 font-bold">
                                /{{ $porto->slug }}
                            </td>

                            <!-- Kolom: Template ID -->
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-lg bg-zinc-900 text-zinc-300 font-semibold capitalize text-xs border border-zinc-800">
                                    {{ $porto->template_id }}
                                </span>
                            </td>

                            <!-- Kolom: Status Publikasi -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if ($porto->status === 'publish' && !$porto->isExpired())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-500/15 text-teal-300 text-xs font-bold border border-teal-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                                        Publish
                                    </span>
                                @elseif ($porto->isExpired())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-500/15 text-rose-400 text-xs font-bold border border-rose-500/30">
                                        Expired
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/15 text-amber-400 text-xs font-bold border border-amber-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>

                            <!-- Kolom: Tanggal Expired -->
                            <td class="px-5 py-4 whitespace-nowrap font-mono text-xs">
                                @if ($porto->expired_at)
                                    <span class="{{ $porto->isExpired() ? 'text-rose-400 font-bold' : 'text-zinc-300' }}">
                                        {{ $porto->expired_at->format('d-m-Y') }}
                                    </span>
                                @else
                                    <span class="text-zinc-500">
                                        Tanpa Batas
                                    </span>
                                @endif
                            </td>

                            <!-- Kolom: Aksi CRUD -->
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- 1. Buka Web Publik di Tab Baru -->
                                    <a href="{{ route('portfolio.public', $porto->slug) }}" target="_blank"
                                       class="p-2 rounded-xl bg-[#101116] border border-zinc-800 text-zinc-300" title="Buka Website">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    </a>

                                    <!-- 2. Edit Form -->
                                    <a href="{{ route('admin.portfolios.edit', $porto->id) }}"
                                       class="p-2 rounded-xl bg-[#101116] border border-zinc-800 text-zinc-300" title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>

                                    {{--
                                      4. Hapus Data (DELETE Request):
                                      Form DELETE dengan konfirmasi javascript dan token CSRF (@csrf + @method('DELETE')).
                                    --}}
                                    <form action="{{ route('admin.portfolios.destroy', $porto->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus portofolio {{ $porto->nama_umkm }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-[#101116] border border-zinc-800 text-zinc-300 cursor-pointer" title="Hapus Portofolio">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-14 text-center text-zinc-500 text-sm">
                                Belum ada website portofolio klien. Klik tombol "Buat Web Baru" untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links bawaan Laravel Paginator --}}
        @if ($portfolios->hasPages())
            <div class="px-6 py-4 border-t border-zinc-800">
                {{ $portfolios->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
