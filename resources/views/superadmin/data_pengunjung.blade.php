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

{{-- Header Section --}}
<div class="section-tabel-custom">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-2">
            <i class="bi bi-people-fill me-2"></i> Data Pengunjung
        </h4>

        <div class="d-flex gap-2 align-items-center mb-2">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="bi bi-funnel-fill me-1"></i> Filter & Pencarian
            </button>
            <a href="#" class="btn btn-outline-success" title="Download PDF"><i class="bi bi-file-earmark-pdf-fill"></i></a>
            <a href="{{ route('superadmin.data_pengunjung') }}" class="btn btn-outline-secondary" title="Refresh"><i class="bi bi-arrow-clockwise"></i></a>
        </div>
    </div>

    <div class="alert alert-info py-2 px-3 mb-4">
        Total Pengunjung: <strong>{{ $totalPengunjung }}</strong>
    </div>

    {{-- Tabel Pengunjung --}}
    <div class="table-responsive-custom">
        <table class="table table-bordered table-hover align-middle text-center table-pengunjung">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NPM</th>
                    <th>Fakultas</th>
                    <th>Program Studi</th>
                    <th>Jenis Anggota</th>
                    <th>Status Anggota</th>
                    <th>Waktu Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataPengunjung as $index => $pengunjung)
                    <tr>
                        <td>{{ $dataPengunjung->firstItem() + $index }}</td>
                        <td class="text-start">
                            {{ Str::title($pengunjung->NamaPengunjung) }}
                            @if($pengunjung->TipePengunjung === 'Non Anggota')
                                <span class="badge bg-light text-dark border ms-2" style="font-size: 0.75rem;">
                                    <i class="bi bi-person-x-fill"></i> Non Anggota
                                </span>
                            @endif
                        </td>
                        <td>{{ $pengunjung->NoAnggota }}</td>
                        <td class="text-start">{{ $pengunjung->NamaFakultas}}</td>
                        <td class="text-start">{{ $pengunjung->NamaProdi}}</td>
                        <td>{{ $pengunjung->JenisAnggota }}</td>
                        <td>
                            @if($pengunjung->StatusAnggota === 'Aktif')
                                <span class="badge bg-success">{{ $pengunjung->StatusAnggota }}</span>
                            @elseif($pengunjung->StatusAnggota === 'Baru')
                                <span class="badge bg-primary">{{ $pengunjung->StatusAnggota }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $pengunjung->StatusAnggota ?? '-' }}</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($pengunjung->WaktuKunjungan, 'UTC')->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-muted">Data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $dataPengunjung->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Modal Filter --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('superadmin.data_pengunjung') }}" method="GET">
        <div class="modal-header">
          <h5 class="modal-title" id="filterModalLabel"><i class="bi bi-funnel-fill me-2"></i>Filter & Pencarian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
            <div class="col-md-6">
              <label for="search" class="form-label">Cari Nama/NPM</label>
              <input type="text" name="search" class="form-control" value="{{ request('search') }}">
            </div>
            <div class="col-md-6">
              <label for="hari" class="form-label">Tanggal</label>
              <input type="date" name="hari" class="form-control" value="{{ request('hari') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Bulan</label>
                <select class="form-select" name="bulan">
                    <option value="">Semua Bulan</option>
                    @foreach ($bulanList as $nomor => $nama)
                        <option value="{{ $nomor }}" {{ request('bulan') == $nomor ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tahun</label>
                <select class="form-select" name="tahun">
                    <option value="all">Semua Tahun</option>
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Jenis Pengunjung</label>
              <select name="tipe" class="form-select">
                  <option value="">Semua</option>
                  <option value="anggota" {{ request('tipe') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                  <option value="non" {{ request('tipe') == 'non' ? 'selected' : '' }}>Non Anggota</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Fakultas</label>
              <select name="fakultas" class="form-select">
                  <option value="">Semua Fakultas</option>
                  @foreach($fakultasList as $item)
                      <option value="{{ $item }}" {{ request('fakultas') == $item ? 'selected' : '' }}>{{ $item }}</option>
                  @endforeach
              </select>
            </div>
            <!-- <div class="col-md-6">
              <label class="form-label">Jurusan</label>
              <select name="jurusan" class="form-select">
                  <option value="">Semua Jurusan</option>
                  @foreach($jurusanList as $item)
                      <option value="{{ $item }}" {{ request('jurusan') == $item ? 'selected' : '' }}>{{ $item }}</option>
                  @endforeach
              </select>
            </div> -->
            <div class="col-md-6">
              <label class="form-label">Program Studi</label>
              <select name="prodi" class="form-select">
                  <option value="">Semua Program Studi</option>
                  @foreach($prodiList as $item)
                      <option value="{{ $item }}" {{ request('prodi') == $item ? 'selected' : '' }}>{{ $item }}</option>
                  @endforeach
              </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
            </button>
            <a href="{{ route('superadmin.data_pengunjung') }}" class="btn btn-outline-danger">
                <i class="bi bi-x-circle me-1"></i> Hapus Filter
            </a>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Auto-refresh jika tidak pakai filter --}}
<!-- @if (!request()->has('search') && !request()->has('hari') && !request()->has('bulan') && !request()->has('tahun') && !request()->has('tipe'))
    <script>
        setTimeout(() => location.reload(), 30000);
    </script>
@endif -->

@endsection