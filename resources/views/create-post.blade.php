@extends('layouts.app')
@section('title', 'create post')
@section('content')

    <div class="w-50 mx-auto mt-5">
        <div class="card">
            <div class="card-header">
                Create post
            </div>
            <div class="card-body">
                <form action="{{ route('submit.post') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" name="title" id="title" placeholder="post title">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                             id="description" rows="3">{{ old('description') }}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" value="{{ old('location') }}"
                            class="form-control @error('location') is-invalid @enderror" name="location" id="location"
                            placeholder="post location">

                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" value="{{ old('category') }}"
                            class="form-control @error('category') is-invalid @enderror" name="category" id="category"
                            placeholder="post category">

                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">image</label>
                        <input type="file" value="{{ old('image') }}"
                            class="form-control @error('image') is-invalid @enderror" name="image" id="image"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload">

                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary mt-3" type="submit">Create post</button>
                </form>
            </div>
        </div>
    </div>

@endsection
