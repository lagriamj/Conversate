<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $search = ($request['search'] != '' || $request['search'] != null) ? $request['search'] : null;

        $data = Post::with(['user'])
            ->withCount(['likes', 'comments'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($subquery) use ($search) {
                    $subquery->where('content', 'ilike', '%' . $search . '%');
                    $subquery->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'ilike', '%' . $search . '%');
                    });
                });
            })
            ->get();

        $message = ($data->count() == 0) ? "No Results Found" : "Results Found";

        return response([
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request['title'],
            'content' => $request['content'],
        ]);

        return response([
            'message' => 'Post Created',
            'data' => $post
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post = Post::find($id);

        if ($post->user_id != Auth::id()) {
            return response([
                'message' => 'Unauthorized'
            ], 401);
        }

        $post->update([
            'title' => $request['title'],
            'content' => $request['content'],

        ]);

        return response([
            'message' => 'Post Updated',
            'data' => $post
        ], 200);
    }

    public function delete($id)
    {
        $post = Post::find($id);

        if ($post->user_id != Auth::id()) {
            return response([
                'message' => 'Unauthorized'
            ], 401);
        }

        $post->delete();

        return response([
            'message' => 'Post Deleted'
        ], 200);
    }

    public function get($id)
    {
        $post = Post::with('user', 'comments.user', 'likes.user', 'comments.likes.user')
            ->withCount(['likes', 'comments'])
            ->with(['comments' => function ($q) {
                $q->withCount('likes');
            }])
            ->find($id);

        return response([
            'message' => 'Post Found',
            'data' => $post
        ], 200);
    }

    public function like($id)
    {
        $post = Post::find($id);

        $post->likes()->create([
            'user_id' => Auth::id()
        ]);

        return response([
            'message' => 'Post Liked'
        ], 201);
    }
    public function unlike($id)
    {
        $post = Post::find($id);

        $post->likes()->where('user_id', Auth::id())->delete();

        return response([
            'message' => 'Post Unliked'
        ], 200);
    }
}