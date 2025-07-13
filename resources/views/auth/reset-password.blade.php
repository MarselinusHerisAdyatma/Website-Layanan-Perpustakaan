{{-- resources/views/auth/reset-password.blade.php --}}
@include('auth._shared-layout', [
    'title' => 'Reset Password',
    'content' => view('auth._reset-password-form', ['token' => $token])
])
