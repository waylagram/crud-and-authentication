<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function allPosts()
    {
        // $posts = Post::all();
        // $posts = Post::with('user', 'comments')->orderBy('created_at', 'desc')->get();// gets all from the database
        $posts = Post::with('user', 'comments')->orderBy('created_at', 'desc')->paginate(2);// Pagination
        // dd($posts);
        return view('all-posts', [
            'posts' => $posts
        ]);
    }


    //create post frontend with a GET request
    public function createPost()
    {
        return view('create-post');
    }


    //create post backend with a POST request
    public function submitPost(Request $request)
    {
        $validator = validator::make($request->all(), [
            'title' => 'required|string|max:15',
            'description' => 'required|min:10',
            'location' => 'required',
            'category' => 'required',
            // 'image' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $formFields = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'category' => $request->input('category'),
            'user_id' => auth()->id()
        ];

        if ($request->image) {
            $image = uniqid() . '-' . 'post-image' . '.' . $request->image->extension();
            $request->image->move(public_path('post'), $image);
            $formFields['image'] = $image;
        }

        $post = Post::create($formFields);

        if ($post) {
            return redirect('/')->with('success', 'Post created successfully');
        } else {
            return redirect('/')->with('error', 'Post could not be created successfully');
        }
    }



    //single post fetch from the database with its comments to frontend with a GET request
    public function singlePost($id)
    {
        $post = Post::find($id);
        $comments = Comment::all();
        return view('single-post', [
            'post' => $post,
            'comments' => $comments
        ]);
    }


    public function editPost($id)
    {
        $post = Post::find($id);
        return view('edit-post', [
            'post' => $post
        ]);
    }

    public function updatePost(Request $request, $id)
    {
        $validator = validator::make($request->all(), [
            'title' => 'required|string|max:15',
            'description' => 'required|min:10',
            'location' => 'required',
            'category' => 'required',
            // 'image' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $formFields = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'category' => $request->input('category')
        ];

        if ($request->image) {
            $image = uniqid() . '-' . 'post-image' . '.' . $request->image->extension();
            $request->image->move(public_path('post'), $image);
            $formFields['image'] = $image;
        }

        $post = Post::where('id', $id)->update($formFields);

        if ($post) {
            return redirect('/single-post/'. $id)->with('success', 'Post updated successfully');
        } else {
            return redirect('/single-post/' . $id)->with('error', 'Post could not be updated successfully');
        }
    }

    public function deletePost($id)
    {
        // $post = Post::find($id);
        $post = Post::where('id', $id)->delete();

        if ($post) {
            return redirect('/')->with('success', 'Post deleted successfully');
        } else {
            return redirect('/')->with('error', 'An error has occured');
        }
    }
}
