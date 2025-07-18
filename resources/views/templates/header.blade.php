<nav class="navbar fixed-top" style="background-color: #1A1687;">
    <div class="container-fluid d-flex align-items-center justify-content-between">
    <!-- Tombol toggler sidebar -->
        <div class="d-flex align-items-center">
            <!-- Tombol Sidebar -->
            <button class="btn text-white me-3" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <i class="bi bi-grid fs-4"></i>
            </button>
            <!-- Tulisan Selamat Datang -->
            <div class="text-white fw-bold fs-5">
                Selamat Datang, {{ Auth::user()->name }}
            </div>
        </div>
        <!-- Kanan: Search bar + Profil -->
        <div class="d-flex align-items-center">
            <!-- Clock -->
            <div id="real-time-clock" class="me-4 text-white fw-bold fs-5"></div>

            <!-- Profil Icon -->
            <div class="d-flex flex-column align-items-center text-center">
                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill text-dark fs-4"></i>
                </div>
                <small class="text-white">{{ Auth::user()->name }}</small>
            </div>
        </div>

    <!-- ====== Sidebar (off-canvas) ====== -->
        <div class="offcanvas offcanvas-start custom-sidebar" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header flex-column align-items-center">
                <img src="{{ asset('images/Logo Perpus Unila.png') }}" alt="Logo" style="height: 70px;">
            </div>
            <hr class="w-100 my-1 border-light">
            {{-- Menu Sidebar Untuk Role Super Admin --}}
            @if(auth()->user()->role_id == 1)
            <div class="offcanvas-body d-flex flex-column justify-content-between">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center hover-effect {{ request()->routeIs('superadmin.index') ? 'active-menu' : '' }}" 
                        href="{{ route('superadmin.index') }}">
                        <i class="bi bi-house-door-fill me-2"></i> Dashboard
                        </a>
                    </li>
                    <hr class="w-100 my-2 border-light">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center hover-effect {{ request()->routeIs('superadmin.data_pengunjung') ? 'active-menu' : '' }}" 
                        href="{{ route('superadmin.data_pengunjung') }}">
                        <i class="bi bi-people-fill me-2"></i> Data Pengunjung
                        </a>
                    </li>
                    <hr class="w-100 my-2 border-light">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center hover-effect {{ request()->routeIs('superadmin.data_peminjaman') ? 'active-menu' : '' }}"
                        href="{{ route('superadmin.data_peminjaman') }}">
                        <i class="bi bi-book-fill me-2"></i> Data Peminjaman Buku
                        </a>
                    </li>
                    <hr class="w-100 my-2 border-light">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center hover-effect {{ request()->routeIs('superadmin.data_akun') ? 'active-menu' : '' }}" 
                        href="{{ route('superadmin.data_akun') }}">
                        <i class="bi bi-person-lines-fill me-2"></i> Data Akun
                        </a>
                    </li>
                    <hr class="w-100 my-2 border-light">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center hover-effect {{ request()->routeIs('superadmin.data_koleksi') ? 'active-menu' : '' }}"
                        href="{{ route('superadmin.data_koleksi') }}">
                            <i class="bi bi-collection-fill me-2"></i> Jumlah Koleksi
                        </a>
                    </li>
                    <hr class="w-100 my-2 border-light">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-danger d-flex align-items-center hover-effect bg-transparent border-0">
                                <i class="bi bi-box-arrow-right me-2"></i> LOG OUT
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endif

            {{-- Menu Sidebar Untuk Role Admin --}}
            @if(auth()->user()->role_id == 2)

            <div class="offcanvas-body d-flex flex-column justify-content-between">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center hover-effect {{ request()->routeIs('admin.index') ? 'active-menu' : '' }}" 
                        href="{{ route('admin.index') }}">
                        <i class="bi bi-house-door-fill me-2"></i> Dashboard
                        </a>
                    </li>
                    <hr class="w-100 my-2 border-light">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center hover-effect {{ request()->routeIs('admin.data_pengunjung') ? 'active-menu' : '' }}" 
                        href="{{ route('admin.data_pengunjung') }}">
                        <i class="bi bi-people-fill me-2"></i> Data Pengunjung
                        </a>
                    </li>
                    <hr class="w-100 my-2 border-light">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center hover-effect {{ request()->routeIs('admin.data_peminjaman') ? 'active-menu' : '' }}"
                        href="{{ route('admin.data_peminjaman') }}">
                        <i class="bi bi-book-fill me-2"></i> Data Peminjaman Buku
                        </a>
                    </li>
                    <hr class="w-100 my-2 border-light">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-danger d-flex align-items-center hover-effect bg-transparent border-0">
                                <i class="bi bi-box-arrow-right me-2"></i> LOG OUT
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</nav>

<script>
    function updateClock() {
        const now = new Date();
        const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const namaHari = hari[now.getDay()];
        const tanggal = now.getDate();
        const namaBulan = bulan[now.getMonth()];
        const tahun = now.getFullYear();

        let jam = now.getHours();
        let menit = now.getMinutes();
        let detik = now.getSeconds();

        // Tambahkan nol di depan jika angkanya < 10
        jam = jam < 10 ? '0' + jam : jam;
        menit = menit < 10 ? '0' + menit : menit;
        detik = detik < 10 ? '0' + detik : detik;

        // Gabungkan semuanya menjadi satu string
        const formattedString = `${namaHari}, ${tanggal} ${namaBulan} ${tahun} | ${jam}:${menit}:${detik}`;

        // Tampilkan hasilnya di dalam div yang sudah kita siapkan
        document.getElementById('real-time-clock').innerHTML = formattedString;
    }

    // Jalankan fungsi updateClock setiap detik (1000 milidetik)
    setInterval(updateClock, 1000);

    // Panggil fungsi sekali saat halaman dimuat agar tidak ada jeda
    updateClock();
</script>
