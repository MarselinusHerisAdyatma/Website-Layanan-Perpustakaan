@extends('templates.dashboard')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Status Koneksi Database</h2>

        <div class="mb-3">
            <h4>🔌 Inlislite</h4>
            <p><strong>Koneksi Aktif:</strong> {{ $inlislite }}</p>
            <p><strong>Database Terdeteksi:</strong> {!! is_string($inlisliteDb) ? $inlisliteDb : $inlisliteDb[0]->db !!}</p>
        </div>

        <div class="mb-3">
            <h4>📚 eLib</h4>
            <p><strong>Koneksi Aktif:</strong> {{ $elib }}</p>
            <p><strong>Database Terdeteksi:</strong> {!! is_string($elibDb) ? $elibDb : $elibDb[0]->db !!}</p>
        </div>
    </div>
@endsection
