@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h4>{{ __('Register to HealthLink') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" id="registration-form">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" placeholder="Enter your name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" placeholder="Enter your email address"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" placeholder="Enter your password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" placeholder="Confirm your password"
                                   class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <!-- Show Password Checkbox -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="show-password">
                            <label class="form-check-label" for="show-password">
                                {{ __('Show Password') }}
                            </label>
                        </div>

                        <!-- Register Button and Login Redirect -->
                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Register') }}
                            </button>
                            <p class="mt-3 text-center">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none text-success">{{ __('Login here') }}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const showPasswordCheckbox = document.getElementById('show-password');
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password-confirm');

    // Toggle password visibility
    showPasswordCheckbox.addEventListener('change', () => {
        if (showPasswordCheckbox.checked) {
            passwordField.type = 'text';
            confirmPasswordField.type = 'text';
        } else {
            passwordField.type = 'password';
            confirmPasswordField.type = 'password';
        }
    });
});

</script>
@endsection