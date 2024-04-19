@extends('layouts.app')

@section('content')
@if(session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif
<div class="container-fluid bg-white">
    <div class="row align-items-center ">
        <!-- Login Header -->
        <div class="login-header col text-center">
            <img src="{{ asset('img/login_page2.jpeg') }}" alt="" class="img-fluid" style="height: 91vh; width: 100%; object-fit: cover;">
        </div>

        <!-- Login Form -->
        <div class="col-md-4 d-flex align-items-center justify-content-center flex-column">
            <div class="text-center">
                <p>Welcome back!</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Password Input -->
                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                    <div class="col-md-8">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="row mb-3">
                    <div class="col-md-8 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Login Button -->
                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class=" button-design btn ">
                            {{ __('Login') }}
                        </button>
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>
                </div>

            </form>

        </div>
        <a href="{{ route('register') }}" class=" btn btn-outline-dark ">Dont have an account? Sign Up</a>

    </div>
</div>
@endsection