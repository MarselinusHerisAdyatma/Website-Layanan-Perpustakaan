{{-- resources/views/auth/forgot-password.blade.php --}}
@include('auth._shared-layout', [
    'title' => 'Lupa Password',
    'content' => view('auth._forgot-password-form')
])


