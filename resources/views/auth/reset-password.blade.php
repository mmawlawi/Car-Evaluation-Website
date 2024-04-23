@section('title', 'Reset Password')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@section('content')
    <div class="container" id="authContainer">
        <div class="auth-form-container">
            <form method="POST" action="{{ route('password.store') }}" class="auth-form">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                        autofocus autocomplete="username" />
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

                <div class="flex justify-end mt-4">
                    <button type="submit">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
