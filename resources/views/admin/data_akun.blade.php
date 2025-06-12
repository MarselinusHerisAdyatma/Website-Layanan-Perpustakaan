@extends('templates.dashboard')

@section('content')
<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
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
      <form method="GET" class="d-flex gap-2">
        <select name="role" class="form-select" onchange="this.form.submit()">
          <option value="">Semua Role</option>
          <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Super Admin</option>
          <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Admin</option>
          <option value="3" {{ request('role') == '3' ? 'selected' : '' }}>User</option>
        </select>
        <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
      </form>
    </div>

    <!-- TOMBOL AKSI -->
    <div class="d-flex justify-content-end gap-2 mb-3">
      <button class="btn btn-outline-success" title="Download PDF">
        <i class="bi bi-file-earmark-pdf-fill"></i>
      </button>
      <a href="{{ route('admin.data_akun') }}" class="btn btn-outline-primary" title="Refresh">
        <i class="bi bi-arrow-clockwise"></i>
      </a>
      
    </div>

    <!-- TABEL -->
    <table class="table table-bordered table-striped align-middle text-center table-akun">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $index => $user)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->username }}</td>
          <td>
          @if ($user->role->id == 1)
            <span class="badge bg-danger">Super Admin</span>
          @elseif ($user->role->id == 2)
            <span class="badge bg-primary">Admin</span>
          @else
            <span class="badge bg-success">User</span>
          @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5">Tidak ada data akun.</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <!-- PAGINATION -->
    <nav class="d-flex justify-content-center mt-4">
      {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
    </nav>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    toastElList.forEach(function (toastEl) {
      new bootstrap.Toast(toastEl, { delay: 4000 }).show();
    });
  });
</script>

@endsection