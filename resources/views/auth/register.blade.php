@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="form-container">
            <div class="form-heading">{{ __('Register') }}</div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-element-group">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input
                        id="name"
                        type="text"
                        class="form-input @error('name') error-input @enderror"
                        name="name"
                        value="{{ old('name') }}" {{--required--}}
                        autocomplete="name"
                        autofocus>

                    @error('name')
                        <span class="error-text" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>


                    <input
                        id="email"
                        type="email"
                        class="form-input @error('email') error-input @enderror"
                        name="email"
                        value="{{ old('email') }}" {{--required--}}
                        autocomplete="email">

                    @error('email')
                        <span class="error-text" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="form-element-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>

                    <input
                        id="password"
                        type="password"
                        class="form-input @error('password') error-input @enderror"
                        name="password" {{--required--}}
                        autocomplete="new-password">

                    @error('password')
                        <span class="error-text" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

                    <input
                        id="password-confirm"
                        type="password"
                        class="form-input"
                        name="password_confirmation" {{--required--}}
                        autocomplete="new-password">
                </div>


                <button type="submit" class="button">
                    {{ __('Register') }}
                </button>
            </form>
        </div>
    </div>

@endsection
