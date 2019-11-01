@extends('layouts.app')

@section('content')
    <p class="mb-4 text-gray-600"><a href="/projects">All Projects <</a> {{ $project->title }}</p>
    @if ($project)
        <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
            <div>
                <h2 class="text-2xl mb-6 border-l-4 border-blue-500 -ml-4 pl-4">
                    {{ $project->title }}
                </h2>
                <p class="mb-6">
                    {{ $project->description }}
                </p>
            </div>
            <div class="flex flex-row items-center">
                <a class="button" href="{{ $project->path() . '/edit' }}">Edit Project</a>
                <form action="{{ $project->path() }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="button" type="submit">Delete</button>
                </form>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
            <p>
                No Project Under That Id
            </p>
        </div>
    @endif
@endsection
