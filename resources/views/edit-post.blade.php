@extends('layouts.app')
@section('title', 'update post')
@section('content')

    <div class="w-50 mx-auto mt-5">
        <div class="card mb-5">
            <div class="card-header">
                Update post
            </div>
            <div class="card-body">
                <form action="{{ route('update.post', $post->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            value="{{ $post->title }}" name="title" id="title" placeholder="post title">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                            rows="3">{{ $post->description }}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" value="{{ $post->location }}"
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
                        <input type="text" value="{{ $post->category }}"
                            class="form-control @error('category') is-invalid @enderror" name="category" id="category"
                            placeholder="post category">

                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div>
                        <img src="{{ asset('post/' . $post->image) }}" alt="" style="width: 13vw">
                    </div>

                    <div class="my-3">
                        <label for="image" class="form-label">image</label>
                        <input type="file" value="{{ $post->image }}"
                            class="form-control @error('image') is-invalid @enderror" name="image" id="image"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload">

                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary mt-3" type="submit" onclick="return check()">Update post</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const check = () => {
            const check = confirm('Are you sure you want to update this post?')
            return check
        }
    </script>
@endsection
