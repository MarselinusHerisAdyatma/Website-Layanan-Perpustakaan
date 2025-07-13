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

<div class="edit-koleksi-wrapper">
    <div class="container">
        <div class="edit-koleksi-card mx-auto shadow">
            <h4 class="edit-koleksi-title mb-4">✏️ Edit Informasi Jumlah Koleksi</h4>

            <form action="{{ route('superadmin.update_koleksi') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="buku" class="form-label">Jumlah Buku</label>
                    <input type="number" id="buku" name="buku" class="form-control custom-input"
                           value="{{ $koleksi->buku ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label for="jurnal" class="form-label">Jumlah Jurnal</label>
                    <input type="number" id="jurnal" name="jurnal" class="form-control custom-input"
                           value="{{ $koleksi->jurnal ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label for="karya_ilmiah" class="form-label">Jumlah Karya Ilmiah</label>
                    <input type="number" id="karya_ilmiah" name="karya_ilmiah" class="form-control custom-input"
                           value="{{ $koleksi->karya_ilmiah ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label for="anggota_aktif" class="form-label">Jumlah Anggota Aktif</label>
                    <input type="number" id="anggota_aktif" name="anggota_aktif" class="form-control custom-input"
                           value="{{ $koleksi->anggota_aktif ?? '' }}">
                </div>

                <div class="mb-3">
                    <label for="ebook_ejournal" class="form-label">Jumlah e-Book & e-Journal</label>
                    <input type="number" id="ebook_ejournal" name="ebook_ejournal" class="form-control custom-input"
                           value="{{ $koleksi->ebook_ejournal ?? '' }}">
                </div>

                <div class="mb-4">
                    <label for="total_koleksi" class="form-label">Jumlah Total Koleksi</label>
                    <input type="number" id="total_koleksi" name="total_koleksi" class="form-control custom-input"
                           value="{{ $koleksi->total_koleksi ?? '' }}" required>
                </div>

                <button type="submit" class="btn btn-primary custom-btn">Update</button>
            </form>
        </div>
    </div>
</div>


@endsection   

       