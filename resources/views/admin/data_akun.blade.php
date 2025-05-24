@extends('templates.dashboard')

@section('content')
<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><i class="bi bi-house-door-fill"></i></li>
        <li>/</li>
        <li>Dashboard</li>
        <li>/</li>
        <li class="active" >Data Akun</li>
    </ol>
</nav>

<div class="section-tabel-custom">
  <div class="table-responsive-custom">
    <!-- JUDUL -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="table-heading">
        <i class="bi bi-person-badge-fill me-2"></i> Tabel Data Akun
      </h5>

      <!-- Filter Dropdown dan Search -->
      <div class="d-flex gap-2">
        <select class="form-select">
          <option value="">Semua Role</option>
          <option value="admin">Super Admin</option>
          <option value="admin">Admin</option>
          <option value="user">User</option>
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
      <button class="btn btn-outline-danger" title="Hapus Semua">
        <i class="bi bi-trash-fill"></i>
      </button>
    </div>

    <!-- TABEL -->
    <table class="table table-bordered table-striped align-middle text-center table-akun">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Fajar Prasetya</td>
          <td>fajar@example.com</td>
          <td><span class="badge bg-primary">Admin</span></td>
          <td>
            <button class="btn btn-outline-primary btn-sm" title="Edit">
              <i class="bi bi-pencil-square"></i>
            </button>
            <button class="btn btn-outline-danger btn-sm" title="Hapus">
              <i class="bi bi-trash-fill"></i>
            </button>
          </td>
        </tr>
        <!-- Tambah data akun lainnya -->
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