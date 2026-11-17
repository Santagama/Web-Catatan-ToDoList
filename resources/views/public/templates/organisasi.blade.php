{{--
  Fallback alias untuk kompatibilitas ke belakang (backward compatibility).
  Jika ada data lama yang menggunakan template_id 'organisasi',
  tampilan otomatis dialihkan me-render template 'barang'.
--}}
@include('public.templates.barang')
