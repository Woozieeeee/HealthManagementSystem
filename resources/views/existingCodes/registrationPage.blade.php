@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Register as Patient</h1>  
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <form action="{{route('register')}}" method="POST">
                @csrf
                <div class="mb-3">
                    {{-- email --}}
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required aria-describedby="emailHelp" autocomplete="email">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text" id="emailHelp">We'll never share your email with anyone else.</div>
                    
                    {{-- password --}}
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8" aria-describedby="passwordHelp">
                            <button type="button" id="toggle-password" class="btn btn-outline-secondary" aria-label="Toggle password visibility">Show</button>
                        </div>
                        @error('password') 
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="passwordHelp" class="form-text">Must be at least 8 characters.</div>
                    </div>

                    {{-- confirm password --}}
                    <div class="mb-3 position-relative">
                        <label for="password-confirm" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required aria-describedby="passwordConfirmHelp">
                            <button class="btn btn-outline-secondary" type="button" id="toggle-password-confirm" aria-label="Toggle confirm password visibility">Show</button>
                        </div>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" id="passwordConfirmHelp">Please re-type your password.</div>
                    </div>
                    
                    {{-- register button --}}
                    <button type="submit" class="btn btn-primary w-100" id="register-button">Register</button>
                </div>
            </form>
            <p class="mt-4 text-center">Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </div>
</div>


@endsection
