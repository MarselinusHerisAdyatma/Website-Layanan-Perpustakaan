@extends('templates.dashboard')

@section('content')

<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li class="active" >Dashboard</li>
    </ol>
</nav>

<!-- DASHBOARD CARD SECTION -->
<div class="dashboard-container">
    <!-- Dropdown -->
    <div class="dropdown-container">
        <label for="filter">Tampilkan berdasarkan:</label>
        <select id="filter" onchange="updateDashboard()">
            <option value="fakultas" selected>Fakultas</option>
            <option value="prodi">Program Studi</option>
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
            <div class="value" id="totalPeminjam">70</div>
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
            <div class="value" id="peminjamTerbanyak">67</div>
            <div class="desc" id="peminjamLabel">Prodi Informatika</div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row-chart">
        <div class="chart-box chart-wrapper">
            <div class="chart-title" id="chartPengunjungLabel">Pengunjung Fakultas Terbanyak</div>
            <canvas id="pengunjungChart"></canvas>
        </div>
        <div class="chart-box chart-wrapper">
            <div class="chart-title" id="chartPeminjamLabel">Peminjam Buku Fakultas Terbanyak</div>
            <canvas id="peminjamChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('pengunjungChart').getContext('2d');
    const ctx2 = document.getElementById('peminjamChart').getContext('2d');

    let pengunjungChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
            datasets: [{
                label: '2025',
                backgroundColor: '#7e3af2',
                data: [60, 80, 70, 75, 85]
            }]
        }
    });

    let peminjamChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
            datasets: [{
                label: '2025',
                borderColor: '#1e88e5',
                backgroundColor: 'rgba(30, 136, 229, 0.3)',
                data: [45, 85, 30, 55, 67],
                fill: true,
                tension: 0.3,
                pointRadius: 4
            }]
        }
    });

    function updateDashboard() {
        const selected = document.getElementById('filter').value;

        if (selected === 'fakultas') {
            document.getElementById('pengunjungTerbanyak').innerText = '80';
            document.getElementById('pengunjungLabel').innerText = 'Fakultas Teknik';

            document.getElementById('peminjamTerbanyak').innerText = '72';
            document.getElementById('peminjamLabel').innerText = 'Fakultas Ilmu Sosial';

            document.getElementById('chartPengunjungLabel').innerText = 'Pengunjung Fakultas Terbanyak';
            document.getElementById('chartPeminjamLabel').innerText = 'Peminjam Buku Fakultas Terbanyak';

            pengunjungChart.data.datasets[0].data = [60, 75, 70, 80, 78];
            peminjamChart.data.datasets[0].data = [50, 60, 45, 75, 72];
        } else {
            document.getElementById('pengunjungTerbanyak').innerText = '65';
            document.getElementById('pengunjungLabel').innerText = 'Prodi Teknik Mesin';

            document.getElementById('peminjamTerbanyak').innerText = '67';
            document.getElementById('peminjamLabel').innerText = 'Prodi Informatika';

            document.getElementById('chartPengunjungLabel').innerText = 'Pengunjung Prodi Terbanyak';
            document.getElementById('chartPeminjamLabel').innerText = 'Peminjam Buku Prodi Terbanyak';

            pengunjungChart.data.datasets[0].data = [55, 60, 65, 70, 60];
            peminjamChart.data.datasets[0].data = [48, 65, 50, 67, 64];
        }

        pengunjungChart.update();
        peminjamChart.update();
    }
</script>

@endsection
