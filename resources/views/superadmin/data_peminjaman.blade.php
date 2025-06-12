@extends('templates.dashboard')

@section('content')
<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('superadmin.index') }}">Dashboard</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li class="active" >Data Peminjaman Buku</li>
    </ol>
</nav>

<div class="section-tabel-custom">
  <div class="table-responsive-custom">
    <!-- JUDUL -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="table-heading">
        <i class="bi bi-book-fill me-2"></i> Tabel Data Peminjaman
      </h5>

      <!-- Filter Dropdown dan Search -->
      <div class="d-flex gap-2">
        <form action="{{ route('superadmin.data_peminjaman') }}" method="GET" class="d-flex gap-2">
          <select name="tahun" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Tahun</option>
          @foreach ($tahunList as $tahun)
            <option value="{{ $tahun }}">{{ $tahun }}</option>
          @endforeach
          </select>
          <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
        </form>
      </div>
    </div>

    <!-- TOMBOL AKSI -->
    <div class="d-flex justify-content-end gap-2 mb-3">
      <a href="#" class="btn btn-outline-success" title="Download PDF">
        <i class="bi bi-file-earmark-pdf-fill"></i>
      </a>
      <a href="{{ route('superadmin.data_peminjaman') }}" class="btn btn-outline-primary" title="Refresh">
        <i class="bi bi-arrow-clockwise"></i>
      </a>
    </div>

    <!-- TABEL -->
    <table class="table table-bordered table-striped align-middle text-center table-peminjaman">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Peminjam</th>
          <th>Judul Buku</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($peminjaman as $index => $data)
        <tr>
          <td>{{ $peminjaman->firstItem() + $index }}</td>
          <td>{{ $data->nama_peminjam }}</td>
          <td>{{ $data->judul_buku }}</td>
          <td>{{ \Carbon\Carbon::parse($data->tanggal_pinjam)->format('d M Y') }}</td>
          <td>{{ $data->tanggal_kembali ? \Carbon\Carbon::parse($data->tanggal_kembali)->format('d M Y') : '-' }}</td>
          <td>
            @if ($data->tanggal_kembali)
              <span class="badge bg-success">Dikembalikan</span>
            @else
              <span class="badge bg-warning text-dark">Belum Kembali</span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6">Tidak ada data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <!-- PAGINATION -->
    <nav class="d-flex justify-content-center mt-4">
      <ul class="pagination">
        {{ $peminjaman->withQueryString()->links('pagination::bootstrap-5') }}
      </ul>
    </nav>
  </div>
</div>



@endsection
