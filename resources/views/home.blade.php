@extends('layouts.app')

@section('content')
<div>
    <div>
        <div>
            <div>
                <div>Dashboard</div>

                <div>
                    @if (session('status'))
                        <div role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div>You are logged in!</div>
                        <div class="mt-4">
                            <a href="/customers" class="button">Customers</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
