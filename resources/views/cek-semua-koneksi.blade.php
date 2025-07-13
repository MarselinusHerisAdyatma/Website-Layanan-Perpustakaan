@extends('templates.dashboard')

@section('content')
<div class="container mt-5">
    <h3>Status Koneksi Semua Database</h3>
    <ul class="list-group mt-3">
        @foreach($status as $conn => $msg)
            <li class="list-group-item">{{ $msg }}</li>
        @endforeach
    </ul>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-4">Kembali</a>
</div>
@endsection
