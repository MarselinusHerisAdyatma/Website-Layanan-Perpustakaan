<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

    <style>
      /* Layout & Global Styles */
      html, body {
          height: 100%;
          margin: 0;
          padding: 0;
          font-family: 'Figtree', Arial, sans-serif;
          background-color: #f4f4f4;
          display: flex;
          flex-direction: column;
      }

      /* Flex wrapper to center login box */
      .main-wrapper {
          flex: 1;
          display: flex;
          align-items: center;
          justify-content: center;
      }

      /* Header */
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

      .close a {
          color: white;
          font-size: 24px;
          text-decoration: none;
      }

      .close a:hover {
          color: #ccc;
      }

      /* Login Box */
      .content {
          background-color: white;
          padding: 30px;
          width: 100%;
          max-width: 500px;
          border: 1px solid #ccc;
          border-radius: 10px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }

      /* Button */
      .btn-submit {
          background-color: #150fa6;
          color: white;
          border: none;
          padding: 10px;
          font-size: 14px;
          cursor: pointer;
      }

      .btn-submit:hover {
          background-color: #0f0b87;
      }

      /* Footer */
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
          transition: color 0.2s;
      }

      .social-icons a:hover i {
          color: #ddd;
      }

    </style>
</head>
<body>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
  @if(session('success'))
    <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          {{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          {{ session('error') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  @endif
</div>

    <!-- Header -->
    <div class="header">
        <img class="img" src="{{ asset('images/Logo Perpus Unila.png') }}" alt="Perpustakaan Logo">
        <div class="close">
            <a href="{{ route('landing_page') }}">
                <i class="bi bi-arrow-left-circle fs-2"></i>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <div class="content">
            <p>Silakan masukkan username dan password Anda untuk login ke sistem layanan perpustakaan.</p>

            <!-- @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif -->

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-submit w-100">Login</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div>
            Dr Jl. Prof. Dr. Ir. Sumantri Brojonegoro No.1, Kota Bandar Lampung, Lampung 35141<br>
            <a href="tel:+6282119970406">📞 +6282119970406</a><br>
            <a href="mailto:library@kpa.unila.ac.id">📧 library@kpa.unila.ac.id</a><br>
            <a href="https://wa.me/6282119970406">💬 6282119970406</a>
        </div>
        <div class="social-icons">
            <strong>Follow Us</strong><br>
            <a href="#" class="me-2 text-white"><i class="bi bi-facebook"></i></a>
            <a href="#" class="me-2 text-white"><i class="bi bi-twitter"></i></a>
            <a href="#" class="me-2 text-white"><i class="bi bi-instagram"></i></a>
            <a href="#" class="me-2 text-white"><i class="bi bi-youtube"></i></a>
        </div>
    </footer>

<script>
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    const toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl).show();
    });
</script>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</html>
