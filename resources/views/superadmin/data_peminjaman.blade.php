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

    <!-- Header Section -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-2">
            <i class="bi bi-book-fill me-2"></i> Data Peminjaman Buku
        </h4>

        <div class="d-flex gap-2 align-items-center mb-2">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="bi bi-funnel-fill me-1"></i> Filter & Pencarian
            </button>
            <a href="#" class="btn btn-outline-success" title="Download PDF">
                <i class="bi bi-file-earmark-pdf-fill"></i>
            </a>
            <a href="{{ route('superadmin.data_peminjaman') }}" class="btn btn-outline-secondary" title="Refresh">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </div>
    </div>

    <!-- Info -->
    <div class="alert alert-info py-2 px-3 mb-4">
        Total Peminjaman: <strong>{{ $peminjaman->total() }}</strong>
    </div>

    <!-- Table -->
    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Fakultas</th>
                <th>Program Studi</th>
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
                    <td class="text-start">{{$data->borrower_name}}</td>
                    <td class="text-start">{{$data->borrower_faculty}}</td>
                    <td class="text-start">{{$data->borrower_jurusan}}</td>
                    <td class="text-start">{{$data->book_title}}</td>
                    <td>{{ $data->loan_date ? \Carbon\Carbon::parse($data->loan_date)->format('d M Y') : '-' }}</td>
                    <td>{{ $data->return_date ? \Carbon\Carbon::parse($data->return_date)->format('d M Y') : '-' }}</td>
                    <td>
                        @if($data->status === 'Dikembalikan')
                            <span class="badge bg-success">{{ $data->status }}</span>
                        @elseif($data->status === 'Terlambat')
                            <span class="badge bg-danger">{{ $data->status }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ $data->status }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-muted">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- PAGINATION -->
    <nav class="d-flex justify-content-center mt-4">
        {{ $peminjaman->withQueryString()->links('pagination::bootstrap-5') }}
    </nav>

  </div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('superadmin.data_peminjaman') }}" method="GET">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-funnel-fill me-2"></i>Filter & Pencarian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
            <div class="col-md-4">
                <label class="form-label">Cari Nama / Judul</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                <option value="">Pilih Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                <option value="">Semua Tahun</option>
                @foreach ($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="hari" class="form-control" value="{{ request('hari') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" class="form-control" value="{{ request('tanggal_kembali') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Fakultas</label>
                <select name="fakultas" class="form-select">
                    <option value="">Semua Fakultas</option>
                    @foreach ($fakultasList as $fakultas)
                        <option value="{{ $fakultas }}" {{ request('fakultas') == $fakultas ? 'selected' : '' }}>
                            {{ $fakultas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Program Studi</label>
                <select name="jurusan" class="form-select">
                    <option value="">Semua Program Studi</option>
                    @foreach ($jurusanList as $jurusan)
                        <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>
                            {{ $jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
                </button>
                <a href="{{ route('superadmin.data_peminjaman') }}" class="btn btn-outline-danger">
                    <i class="bi bi-x-circle me-1"></i> Hapus Filter
                </a>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Auto Refresh --}}
<!-- @if (!request()->anyFilled(['search', 'tahun', 'bulan', 'hari', 'fakultas', 'jurusan']))
    <script>
        setTimeout(() => location.reload(), 30000);
    </script>
@endif -->

@endsection