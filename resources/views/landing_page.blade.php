<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Landing Page - Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Figtree', Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: #150fa6;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header img {
            height: 60px;
        }

        .carousel-inner img {
            height: 450px;
            object-fit: cover;
        }

        .section-numbers {
            padding: 40px 20px;
            background-color: white;
        }

        .section-numbers h3 {
            color: #150fa6;
            margin-bottom: 30px;
        }

        .card-layanan {
            background-color: #150fa6;
            border-radius: 16px;
            padding: 30px 20px;
            color: white;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            text-decoration: none !important;
        }

        .card-layanan:hover {
            background-color: #0e0985;
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .card-layanan i {
            font-size: 3rem;
            margin-bottom: 10px;
            display: block;
        }

        .card-layanan h6 {
            font-size: 1rem;
            font-weight: 600;
            margin-top: 10px;
            margin-bottom: 0;
        }

        .section-layanan a {
            text-decoration: none !important;
        }

        .footer {
            background-color: #150fa6;
            color: white;
            padding: 10px 20px;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .footer a {
            color: white;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .social-icons a i {
            font-size: 20px;
            margin-right: 10px;
        }

        .social-icons a:hover i {
            color: #ddd;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <img src="{{ asset('images/Logo Perpus Unila.png') }}" alt="Logo Perpustakaan">
        <a href="{{ route('login') }}" class="text-white">
            <i class="bi bi-box-arrow-in-right fs-3"></i>
        </a>
    </div>

    <div class="header">
        <img src="{{ asset('images/Logo Perpus Unila.png') }}" alt="Logo Perpustakaan">
        @auth
            <!--  tombol masuk Dashboard -->
            <a href="{{ route('login') }}" class="text-white">
                <button type="submit" class="text-white bg-transparent border-0">
                    Dashboard
                </button>
        </a>
        @else
            <a href="{{ route('login') }}" class="text-white">
                <i class="bi bi-box-arrow-in-right fs-3"></i>
                Login
            </a>
        @endauth
    </div>
    


    <!-- Carousel -->
    <div id="carouselPerpus" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/UPT Unila.jpg') }}" class="d-block w-100" alt="Gambar 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/Perpus 1.jpg') }}" class="d-block w-100" alt="Gambar 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/Perpus 2.jpg') }}" class="d-block w-100" alt="Gambar 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPerpus" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselPerpus" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- LAYANAN UMUM -->
    <div class="section-layanan text-center bg-white py-5">
        <h3 style="color:#150fa6;">Layanan Umum</h3>
        <div class="container mt-4">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <a href="http://opac.unila.ac.id/" class="card-layanan d-block">
                        <i class="bi bi-book-half"></i>
                        <h6>OPAC</h6>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="https://library.unila.ac.id/e-journal/" class="card-layanan d-block">
                        <i class="bi bi-globe"></i>
                        <h6>E-JOURNAL</h6>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="https://library.unila.ac.id/e-book/" class="card-layanan d-block">
                        <i class="bi bi-book"></i>
                        <h6>E-BOOK</h6>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="https://library.unila.ac.id/about/layanan-verifikasi-karya-ilmiah-mahasiswa/" class="card-layanan d-block">
                        <i class="bi bi-check-circle"></i>
                        <h6>Verifikasi Karya Ilmiah</h6>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="https://library.unila.ac.id/pendaftaran-kartu-anggota-perpustakaan/" class="card-layanan d-block">
                        <i class="bi bi-person-plus"></i>
                        <h6>Pendaftaran Anggota</h6>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="https://library.unila.ac.id/layanan-kki/" class="card-layanan d-block">
                        <i class="bi bi-journal-code"></i>
                        <h6>KKI</h6>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="https://library.unila.ac.id/about/surat-keterangan-bebas-perpustakaan-skbp/" class="card-layanan d-block">
                        <i class="bi bi-qr-code-scan"></i>
                        <h6>SKBP</h6>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="https://library.unila.ac.id/digital-library-university-of-lampung/" class="card-layanan d-block">
                        <i class="bi bi-hdd-network"></i>
                        <h6>DIGILIB</h6>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- PERPUSTAKAAN DALAM ANGKA -->
    <div class="section-numbers text-center py-5" style="background-color:#f4f4f4;">
        <h3 style="color:#150fa6;">Perpustakaan Dalam Angka</h3>
        <div class="container mt-4">
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <h4 class="text-primary">{{ number_format($koleksi->buku ?? 0) }}</h4>
                    <p>Buku</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h4 class="text-primary">{{ number_format($koleksi->jurnal ?? 0) }}</h4>
                    <p>Jurnal</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h4 class="text-primary">{{ number_format($koleksi->karya_ilmiah ?? 0) }}</h4>
                    <p>KKI (Koleksi Karya Ilmiah)</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h4 class="text-primary">{{ number_format($koleksi->anggota_aktif ?? 0) }}</h4>
                    <p>Anggota Aktif</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h4 class="text-primary">{{ number_format($koleksi->ebook_ejournal ?? 0) }}</h4>
                    <p>e-Book & e-Journal</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h4 class="text-primary">{{ number_format($koleksi->total_koleksi ?? 0) }}</h4>
                    <p>Jumlah Total Koleksi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps Embed -->
    <div class="text-center my-4">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.358509897351!2d105.23781807590507!3d-5.36215465366666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40c5499b4a5dfb%3A0x47817ff9e8030f2e!2sPerpustakaan%20Universitas%20Lampung!5e0!3m2!1sid!2sid!4v1747993948899!5m2!1sid!2sid" 
            width="100%" 
            height="400" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div>
            Jl. Prof. Dr. Ir. Sumantri Brojonegoro No.1, Bandar Lampung, Lampung 35141<br>
            <a href="tel:+6282119970406">📞 +62 821 1997 0406</a><br>
            <a href="mailto:library@kpa.unila.ac.id">📧 library@kpa.unila.ac.id</a><br>
            <a href="https://wa.me/6282119970406">💬 6282119970406</a>
        </div>
        <div class="social-icons">
            <strong>Follow Us</strong><br>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-youtube"></i></a>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
