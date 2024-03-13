@extends('layouts.auth')
@section('page-title', 'SignIn')
@section('content')
    <div class="card-body p-4">
        <div class="text-center mt-2">
            <h5 class="text-primary">Welcome Back !</h5>
            <p class="text-muted">Sign in to continue to VESTA EVOTON PMS.</p>
        </div>
        <div class="p-2 mt-4">
            <form action="{{ route('login') }} " method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus
                        class="form-control" id="email" placeholder="Enter Email">
                    @error('email')
                        <span class="invald-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    @if (Route::has('password.request'))
                        <div class="float-end">
                            <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a>
                        </div>
                    @endif
                    <label class="form-label" for="password-input">Password</label>
                    <div class="position-relative auth-pass-inputgroup mb-3">
                        <input type="password" class="form-control pe-5 password-input" placeholder="Enter password"
                            id="password-input" name="password" value="{{ old('password') }}" autocomplete="username"
                            required>
                        <button
                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                            type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                    </div>
                    @error('password')
                        <span class="invald-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value=" {{ old('remember') ? 'checked' : '' }}"
                        name="remember" id="auth-remember-check">
                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                </div>

                <div class="mt-4">
                    <button class="btn btn-success w-100" type="submit">Sign In</button>
                </div>

            </form>
        </div>
    </div>
@endsection
