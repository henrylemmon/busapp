@extends('layouts.app')

@section('content')
    <p class="mb-4 text-gray-600">
        <a href="/projects">
            All Projects <
        </a>
        <a href="{{ $project->path() }}">{{ $project->title }}</a> < Edit {{ $project->title }}
    </p>

    <div class="form-container mt-4">
        <div class="form-heading">Update The Project</div>

        <form method="POST" action="{{ $project->path() }}">
            @method('PATCH')
            @csrf

            <div class="form-element-group">
                <label class="form-label" for="title">Title</label>

                <input
                    id="title"
                    type="text"
                    class="form-input @error('email') form-input-invalid @enderror"
                    name="title" {{--required --}}
                    value="{{ $project->title }}"
                >

                @error('title')
                <span class="form-error-text" role="alert">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-element-group">
                <label class="form-label" for="description">Description</label>

                <textarea
                    rows="5" id="description"
                    class="form-textarea @error('password') form-input-invalid @enderror"
                    name="description"
                    {{--required --}}
                >{{ $project->description }}</textarea>

                @error('description')
                <span class="form-error-text" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="flex justify-between">
                <button class="button mr-4" type="submit">
                    Update Project
                </button>
                <a class="button" href="{{ $project->path() }}">Cancel</a>
            </div>
        </form>
    </div>

@endsection
