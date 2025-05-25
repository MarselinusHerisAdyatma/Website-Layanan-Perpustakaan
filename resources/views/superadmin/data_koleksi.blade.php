@extends('templates.dashboard')

@section('content')
<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('superadmin.index') }}">Dashboard</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li class="active"><b>Data Koleksi</b></li>
    </ol>
</nav>

<div class="koleksi-wrapper py-5">
    <div class="container">
        <div class="koleksi-card shadow-lg mx-auto">
            <div class="koleksi-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="koleksi-title mb-1">📚 Informasi Jumlah Koleksi</h1>
                    <p class="koleksi-subtitle">Statistik koleksi perpustakaan terkini</p>
                </div>
                <!-- Tombol edit -->
                <a href="{{ route('superadmin.edit_koleksi') }}" class="btn-edit-icon" title="Edit Koleksi">✏️</a>
            </div>

            <div class="table-responsive">
                <table class="table koleksi-table mb-0 mt-4">
                    <thead>
                        <tr>
                            <th class="text-start">Jenis Koleksi</th>
                            <th style="width: 50px">:</th>
                            <th class="text-start">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="koleksi-label">📖 Buku</td>
                            <td>:</td>
                            <td><span class="koleksi-value">1120</span></td>
                        </tr>
                        <tr>
                            <td class="koleksi-label">📘 Jurnal</td>
                            <td>:</td>
                            <td><span class="koleksi-value">1115</span></td>
                        </tr>
                        <tr>
                            <td class="koleksi-label">📝 Karya Ilmiah</td>
                            <td>:</td>
                            <td><span class="koleksi-value">1110</span></td>
                        </tr>
                        <tr class="koleksi-total-row">
                            <td class="koleksi-label">🧾 Total Koleksi</td>
                            <td>:</td>
                            <td><span class="koleksi-total">3345</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

                

