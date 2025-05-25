@extends('templates.dashboard')

@section('content')
<!-- Breadcrumb -->
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb-custom">
        <li><a href="{{ route('landing_page') }}"><i class="bi bi-house-door-fill"></i></a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('superadmin.index') }}">Dashboard</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li><a href="{{ route('superadmin.data_akun') }}">Data Akun</a></li>
        <li><li><i class="bi bi-chevron-right separator"></i></li></li>
        <li class="active">Edit Akun</li>
    </ol>
</nav>

<div class="akun-container py-5">
    <div class="form-container">
        <h4 class="form-title"><i class="bi bi-pencil-square"></i> Edit Akun</h4>
        <form method="POST" action="{{ route('superadmin.data_akun.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" class="form-control-custom" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control-custom" value="{{ old('username', $user->username) }}" required>
                @error('username')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password Baru (Opsional)</label>
                <input type="password" name="password" class="form-control-custom" autocomplete="new-password">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role_id">Role</label>
                <select name="role_id" class="form-control-custom" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                <a href="{{ route('superadmin.data_akun') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

@endsection
