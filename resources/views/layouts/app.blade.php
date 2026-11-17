{{--
  ==============================================================================
  MASTER LAYOUT UMUM (layouts/app.blade.php)
  ==============================================================================
  Ini adalah kerangka HTML dasar untuk halaman publik dan halaman tamu:
  - Landing Page (public/landing.blade.php)
  - Halaman Login Admin (admin/auth/login.blade.php)
  - Halaman Error 404 (errors/404.blade.php)
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Meta CSRF Token untuk proteksi keamanan request AJAX / form --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Judul halaman dinamis: diisi oleh @section('title', '...') dari masing-masing view --}}
    <title>@yield('title', 'CMS Web Builder')</title>

    <!-- Google Fonts: Instrument Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Kompilasi Tailwind CSS v4 melalui Vite -->
    @vite(['resources/css/app.css'])
</head>
<body class="@yield('body_class', 'bg-white text-slate-900 min-h-screen antialiased flex flex-col justify-between')">

    {{-- Tempat konten utama dari masing-masing halaman disuntikkan --}}
    @yield('content')

</body>
</html>
