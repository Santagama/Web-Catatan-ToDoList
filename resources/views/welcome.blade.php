{{--
  ==============================================================================
  STARTER TEMPLATE (REDIRECT KE LANDING PAGE UTAMA)
  ==============================================================================
  File default Laravel ini disederhanakan agar bersih tanpa animasi/efek berat,
  dan otomatis mengarahkan pengunjung ke halaman utama publik (route 'home').
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="0; url={{ route('home') }}">
    <title>{{ config('app.name', 'CMS Web Builder') }}</title>
</head>
<body class="bg-white text-zinc-900 flex items-center justify-center min-h-screen font-sans">
    <div class="text-center p-6 space-y-2">
        <h1 class="text-xl font-bold">CMS Web Builder</h1>
        <p class="text-sm text-zinc-600">Mengalihkan ke <a href="{{ route('home') }}" class="text-teal-600 underline font-semibold">Beranda Utama</a>...</p>
    </div>
</body>
</html>
