@extends('templates.dashboard')

@section('content')
<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('superadmin.index') }}">Dashboard</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('superadmin.data_koleksi') }}">Data Koleksi</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li class="active" >Edit Koleksi</li>
    </ol>
</nav>

<div class="edit-koleksi-wrapper py-5">
    <div class="container">
        <div class="edit-koleksi-card mx-auto shadow">
            <h4 class="edit-koleksi-title mb-4">✏️ Edit Informasi Jumlah Koleksi</h4>
            <form action="#" method="POST">
                <div class="mb-3">
                    <label for="buku" class="form-label">Jumlah Buku</label>
                    <input type="number" id="buku" name="buku" class="form-control custom-input" placeholder="Masukkan jumlah buku" required>
                </div>
                <div class="mb-3">
                    <label for="jurnal" class="form-label">Jumlah Jurnal</label>
                    <input type="number" id="jurnal" name="jurnal" class="form-control custom-input" placeholder="Masukkan jumlah jurnal" required>
                </div>
                <div class="mb-3">
                    <label for="karya_ilmiah" class="form-label">Jumlah Karya Ilmiah</label>
                    <input type="number" id="karya_ilmiah" name="karya_ilmiah" class="form-control custom-input" placeholder="Masukkan jumlah karya ilmiah" required>
                </div>
                <div class="mb-4">
                    <label for="total" class="form-label">Jumlah Total Koleksi</label>
                    <input type="number" id="total" name="total" class="form-control custom-input" placeholder="Masukkan total koleksi" required>
                </div>
                <button type="submit" class="btn btn-primary custom-btn">Update</button>
            </form>
        </div>
    </div>
</div>



@endsection   

       