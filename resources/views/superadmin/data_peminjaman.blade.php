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
      <form action="{{ route('superadmin.data_peminjaman') }}" method="GET" class="d-flex gap-2">
        <select name="tahun" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Tahun</option>
            @foreach ($tahunList as $tahun)
                {{-- Membuat dropdown tahun tetap terpilih setelah filter --}}
                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endforeach
        </select>
        <input type="text" name="search" class="form-control" placeholder="Cari Judul/Nama..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>
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
                <th>Fakultas/Jurusan</th> 
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
                
                {{-- Teks rata kiri untuk kemudahan membaca --}}
                <td class="text-start">{{ Str::title($data->borrower_name) }}</td>
                <td class="text-start">{{ Str::title($data->borrower_faculty ?? '-') }}</td>
                
                {{-- Teks dipotong dengan elipsis (...) jika terlalu panjang --}}
                <td class="text-start">{{ Str::title($data->book_title) }}</td>
                
                <td>{{ \Carbon\Carbon::parse($data->loan_date)->format('d M Y') }}</td>
                <td>{{ $data->return_date ? \Carbon\Carbon::parse($data->return_date)->format('d M Y') : '-' }}</td>
                <td>
                    @if ($data->return_date)
                        <span class="badge bg-success">Dikembalikan</span>
                    @else
                        <span class="badge bg-warning text-dark">Dipinjam</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Data tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- PAGINATION -->
    <nav class="d-flex justify-content-center mt-4">
        {{-- Ini akan otomatis menyertakan parameter filter (?search=...&tahun=...) --}}
        {{ $peminjaman->links('pagination::bootstrap-5') }}
      </ul>
    </nav>
  </div>
</div>



@endsection
