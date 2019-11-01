@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="form-container mt-4">
            <div class="form-heading">{{ __('Login') }}</div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-element-group">
                    <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email" class="form-input @error('email') form-input-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}" {{--required --}}autocomplete="email" autofocus>

                    @error('email')
                    <span class="form-error-text" role="alert">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-element-group">
                    <label class="form-label" for="password">{{ __('Password') }}</label>

                    <input id="password" type="password"
                           class="form-input @error('password') form-input-invalid @enderror" name="password"
                           {{--required --}}autocomplete="current-password">

                    @error('password')
                    <span class="form-error-text" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input class="mr-2" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="flex justify-between items-end mt-10">
                    <button class="button" type="submit">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

@endsection
