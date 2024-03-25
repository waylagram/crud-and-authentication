@extends('layouts.app')
@section('title', 'All posts')

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
    @endif

    <h2 class="text-center mt-3">All Posts</h2>
    @foreach ($posts as $post)
        <a href="{{ route('single.post', $post->id) }}" class="text-decoration-none text-dark">
            <div class="mt-4 w-25 mx-auto p-3" style="box-shadow: 5px 5px 5px">
                <div class="d-flex justify-content-between">
                    <p>{{ $post->user->first_name }} {{ $post->user->last_name }}</p>
                    <p class="me-3">{{ $post->created_at->format('d.M.y')}}</p>
                </div>
                <img src="{{ asset('post/' . $post->image) }}" alt="" style="width: 22vw">

                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mt-2">Title: {{ $post->title }}</h4>
                        <h4>Category: {{ $post->category }}</h4>
                    </div>
                    <div>
                        <h4 class="mt-4 me-4"><i class="bi bi-chat-dots-fill"></i> {{ $post->comments->count() }}</h4>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    <div class="d-flex mt-5 justify-content-center">
        {{$posts->links() }}
    </div>
@endsection
