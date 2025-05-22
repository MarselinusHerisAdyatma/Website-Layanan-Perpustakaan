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
            <!-- Search form -->
            <form class="me-4 d-flex align-items-center rounded-pill px-3 py-1"
                style="background: linear-gradient(#fff, #e0e0e0); box-shadow: inset 0 0 4px rgba(0,0,0,0.3);">
                <input type="text" class="form-control border-0 shadow-none bg-transparent"
                    placeholder="Cari......" style="width: 150px;">
                <i class="bi bi-search ms-2 text-dark"></i>
            </form>

            <!-- Profil Icon -->
            <div class="text-center">
                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
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
            <hr>
            <div class="offcanvas-body d-flex flex-column justify-content-between">
                <!-- MENU UTAMA -->
                <ul class="navbar-nav">
                    <li class="nav-item mt-2 mb-2">
                        <a class="nav-link text-white d-flex align-items-center hover-effect {{ Request::is('index/admin') ? 'active-menu' : 'text-white hover-effect' }}" href="/index/admin">
                            <i class="bi bi-house-door-fill me-2"></i> Dashboard
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item mt-2 mb-2">
                        <a class="nav-link text-white d-flex align-items-center hover-effect" href="/pengunjung">
                            <i class="bi bi-people-fill me-2"></i> Data Pengunjung
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item mt-2 mb-2">
                        <a class="nav-link text-white d-flex align-items-center hover-effect" href="/peminjaman">
                            <i class="bi bi-book-fill me-2"></i> Data Peminjaman Buku
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item mt-2 mb-2">
                        <a class="nav-link text-white d-flex align-items-center hover-effect" href="/akun">
                            <i class="bi bi-person-lines-fill me-2"></i> Data Akun
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item mt-2 mb-2">
                        <a class="nav-link text-white d-flex align-items-center hover-effect" href="/koleksi">
                            <i class="bi bi-collection-fill me-2"></i> Jumlah Koleksi
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item mt-2 mb-2">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="nav-link text-danger d-flex align-items-center hover-effect" style="background: none; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; width: 100%; text-align: left;">
                                <i class="bi bi-box-arrow-right me-2"></i> LOG OUT
                            </button>
                        </form>
                    </li>
                </ul>

                <!-- PENGATURAN DI BAWAH -->
                <div class="text-center">
                    <a href="/pengaturan-akun" class="text-decoration-none">
                        <div class="bg-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-gear-fill" style="color: #1A1687; font-size: 1.75rem;"></i>
                        </div>
                        <small class="text-white d-block mt-2 mb-4"><b>Pengaturan akun</b></small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>