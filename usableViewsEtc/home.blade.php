@extends('layouts.app')

@section('content')

    <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
        <h2 class="text-2xl mb-6 border-l-4 border-blue-500 -ml-4 pl-4">
            Dashboard
        </h2>

        <div class="card-body">
            @if (session('status'))
                <div class="mb-6" role="alert">
                    {{ session('status') }}
                </div>
            @endif

                <p>You are logged in!</p>
            <a class="hover:underline" href="/projects">Go To Projects ></a>
        </div>
    </div>

@endsection
