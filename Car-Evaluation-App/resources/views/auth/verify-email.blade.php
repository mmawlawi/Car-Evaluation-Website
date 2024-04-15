@extends('layout')

@section('title', 'Verify Email')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@section('content')
    <div class="container" id="authContainer">
        <div class="auth-form-container">
            <div class="mb-4 text-sm" style="color: #666;"> <!-- Adjust the color inline for demonstration -->
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm" style="color: #4CAF50;"> <!-- Success message styling -->
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}" class="auth-form">
                    @csrf

                    <div>
                        <button type="submit" class="button-style"> <!-- Custom button styling -->
                            {{ __('Resend Verification Email') }}
                        </button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="auth-form">
                    @csrf

                    <button type="submit"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
