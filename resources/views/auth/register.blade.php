@extends('layout')

@section('title', 'Register')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@section('content')
    <div class="container" id="authContainer">
        <div class="auth-form-container">
            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        autocomplete="name" />
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="username" />
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password" />
                    @error('password_confirmation')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="ms-4">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
