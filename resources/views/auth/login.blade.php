@extends('layouts.app')
@section('content')
    @if (session('account-error'))
        <div class="row justify-content-end mt-2 mr-2"> <!-- Align the content to the right -->
            <div class="col-md-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('account-error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif


    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center align-item-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header  text-white text-center p-3">
                        <img src="https://safetycircleindia.com/wp-content/uploads/2024/06/Safety-circle-R-logo-changes.png"
                            alt="" class="w-50">
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Enter your email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password" placeholder="Enter your password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{ __('Login') }}
                                </button>
                            </div>

                            {{-- <div class="d-grid mb-3 text-center">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div> --}}

                            <div class="d-grid text-center">
                                <p>Don't have an account? <a class="btn btn-link text-decoration-none"
                                        href="{{ route('register') }}">
                                        {{ __('Register') }}
                                    </a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
