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

<!-- Dropdown Tahun -->
<div class="dropdown-container">
    <label for="tahun">Tahun:</label>
    <select id="tahun" onchange="updateDashboard()">
        <option value="all" {{ $selectedYear === 'all' ? 'selected' : '' }}>Semua Tahun</option>
        @foreach ($tahunList as $tahun)
            <option value="{{ $tahun }}" {{ $tahun == $selectedYear ? 'selected' : '' }}>{{ $tahun }}</option>
        @endforeach
    </select>
</div>


<!-- DASHBOARD CARD SECTION -->
<div class="dashboard-container">
    <!-- Dropdown -->
    <div class="dropdown-container">
        <label for="filter">Tampilkan berdasarkan:</label>
        <select id="filter" onchange="updateDashboard()">
            <option value="fakultas" {{ $filter == 'fakultas' ? 'selected' : '' }}>Fakultas</option>
            <option value="prodi" {{ $filter == 'prodi' ? 'selected' : '' }}>Program Studi</option>
        </select>
    </div>

    <!-- Baris 1: Total -->
    <div class="cards-row">
        <div class="card-box card-blue">
            <h5>Total Pengunjung</h5>
            <div class="value" id="totalPengunjung">150</div>
        </div>
        <div class="card-box card-green">
            <h5>Total Peminjam Buku</h5>
            <div class="value" id="totalPeminjam">{{ $totalPeminjam }}</div>
        </div>
    </div>

    <!-- Baris 2: Terbanyak -->
    <div class="cards-row">
        <div class="card-box card-orange">
            <h5>Pengunjung Terbanyak</h5>
            <div class="value" id="pengunjungTerbanyak">80</div>
            <div class="desc" id="pengunjungLabel">Fakultas Teknik</div>
        </div>
        <div class="card-box card-purple">
            <h5>Peminjam Terbanyak</h5>
            <div class="value" id="peminjamTerbanyak">{{ $peminjamTerbanyak->jumlah ?? 0 }}</div>
            <div class="desc" id="peminjamLabel">{{ $peminjamTerbanyak->{$filter} ?? '-' }}</div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row-chart">
        <div class="chart-box chart-wrapper">
            <div class="chart-title" id="chartPengunjungLabel">Pengunjung {{ ucfirst($filter) }} Terbanyak</div>
            <canvas id="pengunjungChart"></canvas>
        </div>
        <div class="chart-box chart-wrapper">
            <div class="chart-title" id="chartPeminjamLabel">Peminjam Buku {{ ucfirst($filter) }} Terbanyak</div>
            <canvas id="peminjamChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('pengunjungChart').getContext('2d');
    const ctx2 = document.getElementById('peminjamChart').getContext('2d');

    const dataPeminjamChart = @json(array_values($peminjamChart->toArray()));
    const labelPeminjamChart = @json(array_keys($peminjamChart->toArray()));

    const dataPeminjamBulan = @json(array_values($peminjamPerBulan->toArray()));
    const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    let pengunjungChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labelPeminjamChart,
            datasets: [{
                label: 'Total Peminjam per Tahun',
                backgroundColor: '#7e3af2',
                data: dataPeminjamChart
            }]
        }
    });

    let peminjamChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: bulanLabels.slice(0, dataPeminjamBulan.length),
            datasets: [{
                label: '{{ $selectedYear === "all" ? "Semua Tahun" : $selectedYear }}',
                borderColor: '#1e88e5',
                backgroundColor: 'rgba(30, 136, 229, 0.3)',
                data: dataPeminjamBulan,
                fill: true,
                tension: 0.3,
                pointRadius: 4
            }]
        }
    });

    function updateDashboard() {
        const tahun = document.getElementById('tahun').value;
        const filter = document.getElementById('filter').value;
        window.location.href = `?tahun=${tahun}&filter=${filter}`;
    }

</script>

@endsection
