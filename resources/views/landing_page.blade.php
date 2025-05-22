<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  </head>
  <body>
    <div class="landing-page">
      <div class="div">
        <div class="overlap">
          <img class="image" src="{{ asset('images/UPT Unila.jpg') }}" />
          <div class="frame">
            <div class="overlap-group">
              <div class="overlap-2">
                <div class="text-wrapper">Logo</div>
                <img class="img" src="{{ asset('images/Logo Perpus Unila.png') }}" />
              </div>
              <div class="overlap-3">
                <img class="lock" src="{{ asset('images/login.png') }}" />
                <div class="text-wrapper-2"><a href="{{ route('login') }}">LOGIN</a></div>
              </div>
            </div>
          </div>

          <div class="rectangle"></div>
          <div class="rectangle-2"></div>
          <div class="text-wrapper-3">LAYANAN UMUM</div>
          <div class="frame-2">
            <div class="overlap-4">
              <div class="rectangle-3"></div>
              <div class="text-wrapper-4">OPAC</div>
            </div>
            <div class="div-wrapper"><div class="text-wrapper-5">DIGILIB</div></div>
            <div class="overlap-5">
              <div class="rectangle-4"></div>
              <div class="text-wrapper-6">E-JOURNAL</div>
            </div>
            <div class="overlap-6"><div class="text-wrapper-5">EBOOK</div></div>
            <div class="rectangle-5"></div>
          </div>
          <div class="frame-3">
            <div class="overlap-7"><div class="text-wrapper-7">SKBD</div></div>
            <div class="overlap-8">
              <div class="rectangle-4"></div>
              <div class="text-wrapper-8">VERIFIKASI</div>
            </div>
            <div class="overlap-9">
              <div class="rectangle-4"></div>
              <div class="text-wrapper-9">Pendaftaran Anggota</div>
            </div>
            <div class="overlap-6"><div class="text-wrapper-10">DIGILIB</div></div>
          </div>
          
          <div class="rectangle-6"></div>
          <div class="text-wrapper-11">PERPUSTAKAAN DALAM ANGKA</div>
          <img class="image-2" src="img/image.png" />
          <div class="rectangle-7"></div>
          <div class="text-wrapper-12">3345</div>
          <div class="rectangle-8"></div>
          <div class="text-wrapper-13">BUKU</div>
          <div class="text-wrapper-14">1120</div>
          <div class="rectangle-9"></div>
          <div class="JURNAL">JURNAL</div>
          <div class="rectangle-10"></div>
          <div class="text-wrapper-15">JUMLAH TOTAL</div>
          <div class="KKI-koleksi-karya">KKI<br />(Koleksi Karya Ilmiah</div>
          <div class="text-wrapper-16">1115</div>
          <div class="text-wrapper-17">1110</div>
        </div>
        <img class="rectangle-11" src="img/rectangle-2.svg" />
        <div class="overlap-10">
          <div class="overlap-11">
            <div class="text-wrapper-18">Follow Us</div>
            <div class="frame-4">
              <img class="you-tube" src="img/you-tube.png" />
              <img class="instagram" src="img/instagram.png" />
              <img class="vector" src="img/vector.svg" />
              <img class="x" src="img/x.png" />
            </div>
          </div>
          <img class="phone" src="img/phone.png" />
        </div>
      </div>
    </div>
  </body>
</html>
