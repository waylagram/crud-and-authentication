<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\models\Comment;

class CommentController extends Controller
{
    public function comment(Request $request, $postId)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $formFields = [
            'user_id' => auth()->id(),
            'post_id' => $postId,
            'comment' => $request->input('comment')
        ];

        Comment::create($formFields);

        return redirect()->back()->with('success', 'Comment created successfully');
    }
}
