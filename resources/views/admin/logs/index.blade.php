@extends('layouts.admin')

@section('title', 'Activity Log')
@section('page_title', 'Activity Log')

@section('content')
{{--
  ==============================================================================
  ACTIVITY LOG (AUDIT TRAIL SISTEM)
  ==============================================================================
  Merekam jejak setiap aksi admin (Tambah, Edit, Hapus Portofolio, Perpanjangan Paket).
  Dilengkapi filter periode per bulan dan per tahun.
--}}
<div class="space-y-6 sm:space-y-8">

    <!-- ================= HEADER SECTION & FILTER PERIODE ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 tracking-tight">Activity Log</h1>
            {{--
              // SUBTITLE DINAMIS MENGIKUTI FILTER:
              // Menjelaskan periode log yang sedang ditampilkan (Bulan, Tahun, atau Seluruh Waktu)
            --}}
            <p class="text-xs sm:text-sm text-zinc-500 mt-1 font-medium">
                @if (request()->filled('bulan') && request()->filled('tahun'))
                    Riwayat aktivitas admin bulan {{ Carbon\Carbon::create(2026, request('bulan'), 1)->locale('id')->translatedFormat('F') }} {{ request('tahun') }}
                @elseif (request()->filled('bulan'))
                    Riwayat aktivitas admin bulan {{ Carbon\Carbon::create(2026, request('bulan'), 1)->locale('id')->translatedFormat('F') }}
                @elseif (request()->filled('tahun'))
                    Riwayat aktivitas admin tahun {{ request('tahun') }}
                @else
                    Riwayat seluruh aktivitas admin sistem
                @endif
            </p>
        </div>

        {{-- Filter Dropdown Bulan & Tahun --}}
        <form action="{{ route('admin.logs.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
            <div class="relative">
                <select name="bulan" class="px-3.5 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-800 text-xs sm:text-sm font-semibold outline-none cursor-pointer">
                    <option value="">Semua Bulan</option>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create(2026, $m, 1)->locale('id')->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="relative">
                <select name="tahun" class="px-3.5 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-800 text-xs sm:text-sm font-semibold outline-none cursor-pointer">
                    <option value="">Semua Tahun</option>
                    @foreach (range(now()->year, now()->year - 2) as $y)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            {{--
              // UBAH WARNA TOMBOL 'TERAPKAN FILTER':
              // Ganti 'bg-teal-600' jadi 'bg-blue-600' (biru)
            --}}
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-teal-600 text-white text-xs sm:text-sm font-bold shadow-xs cursor-pointer">
                Terapkan
            </button>

            @if(request('bulan') || request('tahun'))
                <a href="{{ route('admin.logs.index') }}" class="px-3 py-2.5 rounded-xl bg-zinc-100 text-zinc-700 text-xs font-semibold border border-zinc-200">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- ================= 4 KARTU METRIK AKTIVITAS ================= -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-5">
        <!-- TOTAL -->
        <div class="p-5 rounded-3xl bg-white border border-zinc-200 shadow-sm">
            <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider block mb-1">TOTAL</span>
            <p class="text-2xl sm:text-3xl font-extrabold text-zinc-900">{{ $summaryBulanIni['total'] ?? $logs->total() }}</p>
        </div>

        <!-- TAMBAH -->
        <div class="p-5 rounded-3xl bg-white border border-zinc-200 shadow-sm">
            <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider block mb-1">TAMBAH</span>
            <p class="text-2xl sm:text-3xl font-extrabold text-zinc-900">{{ $summaryBulanIni['tambah'] }}</p>
        </div>

        <!-- EDIT -->
        <div class="p-5 rounded-3xl bg-white border border-zinc-200 shadow-sm">
            <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider block mb-1">EDIT</span>
            <p class="text-2xl sm:text-3xl font-extrabold text-zinc-900">{{ $summaryBulanIni['edit'] }}</p>
        </div>

        <!-- HAPUS -->
        <div class="p-5 rounded-3xl bg-white border border-zinc-200 shadow-sm">
            <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider block mb-1">HAPUS</span>
            <p class="text-2xl sm:text-3xl font-extrabold text-zinc-900">{{ $summaryBulanIni['hapus'] }}</p>
        </div>
    </div>

    <!-- ================= TIMELINE LOG AKTIVITAS ================= -->
    <div class="rounded-3xl bg-white border border-zinc-200 p-6 sm:p-8 shadow-sm">
        <div class="relative pl-6 sm:pl-8 border-l-2 border-zinc-200 space-y-6">
            @forelse ($logs as $log)
                <div class="relative">
                    <!-- Dot Indikator di Garis Timeline -->
                    <span class="absolute -left-[31px] sm:-left-[39px] top-4 w-3.5 h-3.5 rounded-full bg-teal-500 border-2 border-white"></span>

                    <!-- Card Log Item -->
                    <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Action Badge -->
                            @php
                                $badgeColor = match(true) {
                                    str_contains($log->action, 'TAMBAH') => 'bg-teal-500/20 text-teal-700 border-teal-500/40',
                                    str_contains($log->action, 'EDIT') => 'bg-cyan-500/20 text-cyan-700 border-cyan-500/40',
                                    str_contains($log->action, 'HAPUS') => 'bg-rose-500/20 text-rose-600 border-rose-500/40',
                                    default => 'bg-zinc-100 text-zinc-600 border-zinc-200',
                                };
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold border uppercase tracking-wider {{ $badgeColor }}">
                                {{ $log->action }}
                            </span>

                            <span class="text-xs text-zinc-500">
                                oleh <strong class="text-zinc-800">{{ $log->admin->name ?? 'Admin' }}</strong>
                            </span>

                            {{-- Relasi Eloquent ke Portfolio (jika log terkait dengan portofolio tertentu) --}}
                            @if ($log->portfolio)
                                <span class="text-zinc-400">&bull;</span>
                                <span class="text-xs text-zinc-500 font-medium">
                                    web {{ $log->portfolio->nama_umkm }}
                                </span>
                            @endif
                        </div>

                        <!-- Deskripsi Aktivitas -->
                        <p class="text-sm font-semibold text-zinc-900 leading-relaxed">
                            {{ $log->description }}
                        </p>

                        <!-- Waktu Pencatatan: Bahasa Indonesia Bersih -->
                        <div class="flex items-center gap-2 text-xs text-zinc-400 pt-1">
                            <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ $log->created_at->locale('id')->translatedFormat('l, d F Y, H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-zinc-400 text-sm">
                    Tidak ada aktivitas admin yang tercatat pada periode ini.
                </div>
            @endforelse
        </div>

        @if ($logs->hasPages())
            <div class="pt-6 mt-6 border-t border-zinc-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
