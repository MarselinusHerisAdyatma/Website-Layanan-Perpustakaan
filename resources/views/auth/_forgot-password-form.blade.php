<p>Masukkan alamat email Anda untuk menerima link reset password.</p>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Alamat Email</label>
        <input type="email" name="email" class="form-control" required>
        @error('email')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-submit w-100">Kirim Link Reset</button>
</form>