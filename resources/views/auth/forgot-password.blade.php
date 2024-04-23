@extends('layout')

@section('title', 'Forgot Password')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@section('content')
    <div class="container" id="authContainer">
        <div class="auth-form-container">
            <div class="mb-4 text-sm" style="color: #666;"> <!-- Modified the color inline for demonstration -->
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
