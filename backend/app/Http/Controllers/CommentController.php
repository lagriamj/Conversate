<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post Not Found',
            ], 404);
        }

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request['content'],
        ]);


        return response([
            'message' => 'Comment Created',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = Comment::find($id);
        if (!$comment->isEdited) {
            $comment->update([
                'content' => $request['content'],
                'isEdited' => true

            ]);
        } else {
            $comment->update([
                'content' => $request['content']
            ]);
        }

        return response([
            'message' => 'Comment Updated',
            'data' => $comment
        ], 200);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response([
            'message' => 'Comment Deleted',
            'data' => $comment
        ], 200);
    }

    public function like($id)
    {
        $comment = Comment::find($id);

        $like = $comment->likes()->where('user_id', Auth::id())->first();

        if (!$like) {
            $comment->likes()->create([
                'user_id' => Auth::id()
            ]);
        } else {
            return response([
                'message' => 'You already liked this comment'
            ], 422);
        }



        return response([
            'message' => 'Comment Liked',
        ], 201);
    }

    public function unlike($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response([
                'message' => 'Comment Not Found',
            ], 404);
        }

        $comment->likes()->where('user_id', Auth::id())->delete();

        return response([
            'message' => 'Comment Unliked',

        ], 200);
    }
}