@extends('layouts.app')
@section('title', 'single post')

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

    <h2 class="text-center mt-3">Post</h2>
    <div class="mt-4 w-25 mx-auto p-3" style="box-shadow: 5px 5px 5px">
        <div class="d-flex justify-content-between">
            <p>{{ $post->user->first_name }} {{ $post->user->last_name }}</p>
            <p>{{ $post->created_at->format('h.i.s') }}</p>
        </div>
        <img src="{{ asset('post/' . $post->image) }}" alt="" style="width: 23vw">
        <h4><span class="text-primary">Title:</span> {{ $post->title }}</h4> <br>
        <h4><span class="text-primary">Category:</span> {{ $post->category }}</h4> <br>
        <h4><span class="text-primary">Location:</span> {{ $post->location }}</h4> <br>
        <h4><span class="text-primary">Description</span> <br> {{ $post->description }}</h4>

        {{-- @if (auth()->user()->id == $post->user_id) --}}
        <hr>
        <div class="d-flex justify-content-between">
            @if (auth()->user()->id == $post->user_id)
                <div class="d-flex">
                    <a class="me-1" href="{{ route('edit.post', $post->id) }}">
                        <button class="btn btn-primary" onclick="return checker()">Edit</button>
                    </a>

                    <form action="{{ route('delete.post', $post->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="return check()">Delete</button>
                    </form>
                </div>
            @endif
            <h4 class="mt-1"><i class="bi bi-chat-dots-fill"></i> {{ $post->comments->count() }}</h4>

        </div>

        {{-- <h4 class="mt-1"><i class="bi bi-chat-dots-fill"></i> {{ $post->comments->count() }}</h4> --}}
    </div>

    <div class="text-center mt-5">
        <form action="{{ route('comment', $post->id) }}" method="POST">
            @csrf
            <label for="comment">Comment</label> <br>
            <textarea name="comment" class="form-control w-50 mx-auto" id="comment" cols="50" rows="5"></textarea>
            <button type="submit" class="btn btn-primary mt-3">Comment</button>
        </form>
    </div>

    <div>
        <p class="text-center mt-4"> All Comments</p>
        <div>
            @foreach ($comments as $comment)
                @if ($post->id == $comment->post_id)
                    <div class="w-50 mx-auto d-flex justify-content-between text-light bg-primary p-3 text-center mt-2">
                        <p>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</p>
                        <p class="mx-auto">{{ $comment->comment }}</p>
                        <p>{{ $comment->created_at->format('h.i.s') }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <script>
        const check = () => {
            const check = confirm('Are you sure you want to delete?')
            return check
        }

        const checker = () => {
            const checker = confirm('Are you sure you want to edit this post?')
            return checker
        }
    </script>
@endsection
