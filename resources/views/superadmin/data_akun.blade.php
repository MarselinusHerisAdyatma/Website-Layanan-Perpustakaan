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
        <li class="active">Data Akun</li>
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
      <a href="{{ route('superadmin.data_akun.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i> Tambah Akun
      </a>
      <button class="btn btn-outline-success" title="Download PDF">
        <i class="bi bi-file-earmark-pdf-fill"></i>
      </button>
      <a href="{{ route('superadmin.data_akun') }}" class="btn btn-outline-primary" title="Refresh">
        <i class="bi bi-arrow-clockwise"></i>
      </a>
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
          <th>Username</th>
          <th>Role</th>
          <th>Aksi</th>
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
          <td>
              <a href="{{ route('superadmin.data_akun.edit', $user->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                <i class="bi bi-pencil-square"></i>
              </a>
              <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $user->id }}">
                  <i class="bi bi-trash-fill"></i>
              </button>

              <!-- Modal Konfirmasi Hapus -->
              <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                      <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}"><i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus akun <strong>{{ $user->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                      <form action="{{ route('superadmin.data_akun.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
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
