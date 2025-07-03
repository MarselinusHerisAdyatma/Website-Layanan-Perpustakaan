@extends('templates.dashboard')

@section('content')
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('superadmin.index') }}">Dashboard</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li class="active" >Data Pengunjung</li>
    </ol>
</nav>

<div class="section-tabel-custom">
  <div class="table-responsive-custom">
    <form action="{{ route('superadmin.data_pengunjung') }}" method="GET">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="table-heading">
            <i class="bi bi-people-fill me-2"></i> Tabel Data Pengunjung
          </h5>

          <div class="d-flex gap-2">
            <select class="form-select" name="tahun">
              <option value="all">Semua Tahun</option>
              {{-- Ganti tahun ini sesuai dengan data yang Anda miliki --}}
              <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
              <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>2024</option>
              <option value="2023" {{ request('tahun') == '2023' ? 'selected' : '' }}>2023</option>
            </select>
            <input type="text" name="search" class="form-control" placeholder="Cari Nama/NPM..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
          </div>
        </div>
    </form>
    <div class="d-flex justify-content-end gap-2 mb-3">
      <a href="#" class="btn btn-outline-success" title="Download PDF">
        <i class="bi bi-file-earmark-pdf-fill"></i>
      </a>
      <a href="{{ route('superadmin.data_pengunjung') }}" class="btn btn-outline-primary" title="Refresh">
        <i class="bi bi-arrow-clockwise"></i>
      </a>
    </div>

    <table class="table table-bordered table-striped align-middle text-center table-pengunjung">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NPM</th>
                <th>Fakultas</th>
                <th>Jurusan / Prodi</th>
                <th>Jenis Anggota</th>
                <th>Status Anggota</th>
                <th>Waktu Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataPengunjung as $index => $pengunjung)
                <tr>
                    <td>{{ $dataPengunjung->firstItem() + $index }}</td>
                    <td class="text-start">{{ Str::title($pengunjung->NamaPengunjung) }}</td>
                    <td>{{ $pengunjung->NoAnggota ?? '-' }}</td>
                    <td class="text-start">{{ Str::title($pengunjung->NamaFakultas ?? '-') }}</td>
                    <td class="text-start">{{ Str::title($pengunjung->NamaJurusan ?? '') }} - {{ Str::title($pengunjung->NamaProdi ?? '') }}</td>
                    <td>{{ Str::title($pengunjung->jenisanggota ?? '-') }}</td>
                    <td>
                        {{-- Beri warna pada status agar mudah dilihat --}}
                        @if($pengunjung->NamaStatus == 'Aktif')
                            <span class="badge bg-success">{{ $pengunjung->NamaStatus }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $pengunjung->NamaStatus ?? '-' }}</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($pengunjung->CreateDate)->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <nav class="d-flex justify-content-center mt-4">
        {{-- Kode ini sudah benar, tidak perlu diubah. --}}
        {{-- withQueryString() di Controller akan membuat filter tetap aktif saat pindah halaman --}}
        {{ $dataPengunjung->links('pagination::bootstrap-5')}}
    </nav>
  </div>
</div>

@endsection