@extends('templates.dashboard')

@section('content')
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
  @if(session('success'))
    <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          {{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          {{ session('error') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  @endif
</div>

<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('superadmin.index') }}">Dashboard</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li class="active"><b>Data Koleksi</b></li>
    </ol>
</nav>

<div class="koleksi-wrapper">
    <div class="container">
        <div class="koleksi-card shadow-lg mx-auto">
            <div class="koleksi-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="koleksi-title mb-1">📚 Informasi Jumlah Koleksi</h1>
                    <p class="koleksi-subtitle">Statistik koleksi perpustakaan terkini</p>
                </div>
                <a href="{{ route('superadmin.edit_koleksi') }}" class="btn-edit-icon" title="Edit Koleksi">✏️</a>
            </div>

            <div class="table-responsive">
                <table class="table koleksi-table mb-0 mt-4">
                    <thead>
                        <tr>
                            <th class="text-start">Jenis Koleksi</th>
                            <th style="width: 50px">:</th>
                            <th class="text-start">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="koleksi-label">📖 Buku</td>
                            <td>:</td>
                            <td><span class="koleksi-value">{{ $koleksi->buku ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td class="koleksi-label">📘 Jurnal</td>
                            <td>:</td>
                            <td><span class="koleksi-value">{{ $koleksi->jurnal ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td class="koleksi-label">📝 Karya Ilmiah</td>
                            <td>:</td>
                            <td><span class="koleksi-value">{{ $koleksi->karya_ilmiah ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td class="koleksi-label">👥 Anggota Aktif</td>
                            <td>:</td>
                            <td><span class="koleksi-value">{{ $koleksi->anggota_aktif ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td class="koleksi-label">📚 e-Book & e-Journal</td>
                            <td>:</td>
                            <td><span class="koleksi-value">{{ $koleksi->ebook_ejournal ?? '-' }}</span></td>
                        </tr>
                        <tr class="koleksi-total-row">
                            <td class="koleksi-label">🧾 Total Koleksi</td>
                            <td>:</td>
                            <td><span class="koleksi-total">{{ $koleksi->total_koleksi ?? '-' }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toastElList = [].slice.call(document.querySelectorAll('.toast'))
    toastElList.forEach(function (toastEl) {
      new bootstrap.Toast(toastEl, { delay: 4000 }).show()
    })
  });
</script>

@endsection

                

