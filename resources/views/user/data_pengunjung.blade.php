@extends('templates.dashboard')

@section('content')
<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('user.index') }}">Dashboard</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li class="active" >Data Pengunjung</li>
    </ol>
</nav>

<div class="section-tabel-custom">
  <div class="table-responsive-custom">
    <!-- JUDUL -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="table-heading">
        <i class="bi bi-people-fill me-2"></i> Tabel Data Pengunjung
      </h5>

      <!-- Filter Dropdown dan Search -->
      <div class="d-flex gap-2">
        <select class="form-select">
          <option value="">Semua Tahun</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
        </select>
        <input type="text" class="form-control" placeholder="Cari...">
      </div>
    </div>

    <!-- TOMBOL AKSI -->
    <div class="d-flex justify-content-end gap-2 mb-3">
      <button class="btn btn-outline-success" title="Download PDF">
        <i class="bi bi-file-earmark-pdf-fill"></i>
      </button>
      <button class="btn btn-outline-primary" title="Refresh">
        <i class="bi bi-arrow-clockwise"></i>
      </button>
    </div>

    <!-- TABEL -->
    <table class="table table-bordered table-striped align-middle text-center table-pengunjung">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Asal</th>
          <th>Tanggal</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Aldo</td>
          <td>Fakultas Teknik</td>
          <td>2024-05-24</td>
          <td>08:45</td>
        </tr>
        <!-- Tambah data lainnya -->
      </tbody>
    </table>

    <!-- PAGINATION -->
    <nav class="d-flex justify-content-center mt-4">
      <ul class="pagination pagination-lg">
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
      </ul>
    </nav>
  </div>
</div>



@endsection