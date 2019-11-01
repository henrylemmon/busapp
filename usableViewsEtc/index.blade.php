@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600"><a href="/projects">All Projects</a></p>
        <a class="button" href="/projects/create">New Project</a>
    </div>
    <div class="flex flex-wrap -mx-3">

        @forelse($projects as $project)

            <div class="w-1/3 px-3">
                <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
                    <h2 class="text-2xl mb-6 border-l-4 border-blue-500 -ml-4 pl-4">
                        <a href="{{ $project->path() }}">
                            {{ $project->title }}
                        </a>
                    </h2>
                    <div>{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
                    <p class="my-6">Read More ></p>
                </div>
            </div>

        @empty
            <div>No Projects Yet!</div>
        @endforelse
    </div>
@endsection
