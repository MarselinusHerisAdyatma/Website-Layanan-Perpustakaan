@extends('templates.dashboard')

@section('content')

<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li class="active">Dashboard</li>
    </ol>
</nav>

<!-- DASHBOARD CARD SECTION -->
<div class="dashboard-container">

<!-- FILTER KONEKSI DATABASE -->
<div class="alert alert-info">
    <strong>Koneksi Pengunjung:</strong> {{ session('inlislite_connection', 'mysql_inlislite_local') }} <br>
    <strong>Koneksi Peminjaman:</strong> {{ session('elib_connection', 'sqlsrv_elib_local') }}
</div>

<div>
  🔌 INLIS: {{ session('inlislite_connection') ?? '❌ tidak terhubung' }}<br>
  📚 eLib: {{ session('elib_connection') ?? '❌ tidak terhubung' }}
</div>


    <!-- FILTER BAR: Koneksi + Prodi/Fakultas + Tahun -->
    <div class="d-flex justify-content-end gap-2 mb-3">
        <!-- Form Filter Prodi/Fakultas dan Tahun -->
            <form action="{{ route('superadmin.index') }}" method="GET" id="filterForm" class="d-flex gap-2">
                
                <select id="filter" name="filter" class="form-select" onchange="this.form.submit()">
                    <option value="fakultas" {{ $filter == 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                    <option value="prodi" {{ $filter == 'prodi' ? 'selected' : '' }}>Program Studi</option>
                </select>

                <select id="bulan" name="bulan" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $selectedMonth == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach ($bulanList as $nomor => $nama)
                        <option value="{{ $nomor }}" {{ $selectedMonth == $nomor ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>

                <select id="tahun" name="tahun" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>Semua Tahun</option>
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ $tahun == $selectedYear ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>

            </form>
            <a href="{{ route('superadmin.index') }}" class="btn btn-outline-secondary d-flex align-items-center" title="Hapus Filter">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
    </div>

    <!-- Baris 1: Total -->
    <div class="cards-row">
        <div class="card-box card-blue">
            <h5>Total Pengunjung (Tahun {{ $selectedYear == 'all' ? 'Akumulasi' : $selectedYear }})</h5>
            <div class="value">{{ number_format($totalPengunjung) }}</div>
        </div>
        <div class="card-box card-green">
            <h5>Total Peminjaman (Tahun {{ $selectedYear == 'all' ? 'Akumulasi' : $selectedYear }})</h5>
            <div class="value">{{ number_format($totalPeminjam) }}</div>
        </div>
    </div>

    <!-- Baris 2: Terbanyak -->
    <div class="cards-row">
        <div class="card-box card-orange">
            <h5>Pengunjung Terbanyak</h5>
            <div class="value">{{ number_format($pengunjungTerbanyak->jumlah ?? 0) }}</div>
            <div class="desc">Dari {{ $namaKategoriFilter }}: {{ $pengunjungTerbanyak->kategori ?? '-' }}</div>
        </div>
        <div class="card-box card-purple">
            <h5>Peminjam Terbanyak</h5>
            <div class="value">{{ number_format($peminjamTerbanyak->jumlah ?? 0) }}</div>
            <div class="desc">Dari Fakultas: {{ Str::title($peminjamTerbanyak->borrower_faculty ?? '-') }}</div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row-chart">
        <div class="chart-box">
            <div class="chart-title">Top 5 {{ $namaKategoriFilter }} Pengunjung (Tahun {{ $selectedYear == 'all' ? 'Akumulasi' : $selectedYear }})</div>
            <div class="chart-wrapper">
                <canvas id="pengunjungTopChart"></canvas>
            </div>
        </div>
        <div class="chart-box">
            <div class="chart-title">Top 5 Fakultas Peminjam (Tahun {{ $selectedYear == 'all' ? 'Akumulasi' : $selectedYear }})</div>
            <div class="chart-wrapper">
                <canvas id="peminjamTopChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row-chart mt-4">
        <div class="chart-box">
            <div class="chart-title">Tren Pengunjung per Tahun</div>
            <div class="chart-wrapper">
                <canvas id="pengunjungTrendChart"></canvas>
            </div>
        </div>
        <div class="chart-box">
            <div class="chart-title">Tren Peminjaman per Tahun</div>
            <div class="chart-wrapper">
                <canvas id="peminjamTrendChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari Controller
    const pengunjungTopData = @json($topPengunjung);
    const peminjamTopData = @json($topPeminjam);
    const pengunjungTrendData = @json($pengunjungPerTahun);
    const peminjamTrendData = @json($peminjamPerTahun);

    // ======================================================
    // CHART TOP 5 PENGUNJUNG (BAR CHART - DENGAN PERBAIKAN)
    // ======================================================
    const ctx1 = document.getElementById('pengunjungTopChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: Object.keys(pengunjungTopData), // Label asli tetap di sini
            datasets: [{ label: 'Jumlah Pengunjung', data: Object.values(pengunjungTopData), backgroundColor: 'rgba(255, 159, 64, 0.7)' }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        // Fungsi untuk memotong label jika terlalu panjang
                        callback: function(value) {
                            const label = this.getLabelForValue(value);
                            if (label.length > 20) { // Batasi panjang label
                                return label.substring(0, 20) + '...';
                            }
                            return label;
                        }
                    }
                },
                y: { beginAtZero: true }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        // Menampilkan label asli yang tidak terpotong di tooltip
                        title: function(context) {
                            return context[0].label;
                        }
                    }
                }
            }
        }
    });

    // ======================================================
    // CHART TOP 5 PEMINJAM (BAR CHART - DENGAN PERBAIKAN)
    // ======================================================
    const ctx2 = document.getElementById('peminjamTopChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: Object.keys(peminjamTopData), // Label asli tetap di sini
            datasets: [{ label: 'Jumlah Peminjam', data: Object.values(peminjamTopData), backgroundColor: 'rgba(153, 102, 255, 0.7)' }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        // Fungsi untuk memotong label jika terlalu panjang
                        callback: function(value) {
                            const label = this.getLabelForValue(value);
                            if (label.length > 20) { // Batasi panjang label
                                return label.substring(0, 20) + '...';
                            }
                            return label;
                        }
                    }
                },
                y: { beginAtZero: true }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        // Menampilkan label asli yang tidak terpotong di tooltip
                        title: function(context) {
                            return context[0].label;
                        }
                    }
                }
            }
        }
    });

    // ======================================================
    // CHART TREN (LINE CHART - TIDAK ADA PERUBAHAN)
    // ======================================================
    const ctx3 = document.getElementById('pengunjungTrendChart').getContext('2d');
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: Object.keys(pengunjungTrendData),
            datasets: [{ label: 'Total Pengunjung per Tahun', data: Object.values(pengunjungTrendData), borderColor: '#34568B', tension: 0.1, fill: false }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

    const ctx4 = document.getElementById('peminjamTrendChart').getContext('2d');
    new Chart(ctx4, {
        type: 'line',
        data: {
            labels: Object.keys(peminjamTrendData),
            datasets: [{ label: 'Total Peminjaman per Tahun', data: Object.values(peminjamTrendData), borderColor: '#6B5B95', tension: 0.1, fill: false }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });
</script>

@endsection
