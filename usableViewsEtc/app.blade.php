<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="bg-gray-300">
        <div>
            <nav class="bg-white py-4">
                <div class="container mx-auto">
                    <div class="flex justify-between">
                        {{--left side--}}
                        <div>
                            <h1 class="text-3xl">
                                <a class="navbar-brand" href="{{ url('/projects') }}">
                                    {{ config('app.name', 'Laravel') }}
                                </a>
                            </h1>
                        </div>
                        {{--end left side--}}

                        <!-- Right Side Of Navbar -->
                        <div>
                            @guest
                                <div>
                                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                </div>
                                @if (Route::has('register'))
                                    <div>
                                        <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </div>
                                @endif
                            @else
                                <div>
                                    <div>
                                        {{ Auth::user()->name }}
                                    </div>

                                    <div>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            @endguest

                        </div>
                        {{--end of right side--}}
                    </div>
                </div>{{--container mx-auto--}}
            </nav>

            <main class="container mx-auto pt-6">
                @yield('content')
            </main>
        </div>
    </div>{{--#app--}}
</body>
</html>
