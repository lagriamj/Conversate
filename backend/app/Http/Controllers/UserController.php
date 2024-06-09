<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateValidation;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showPosts($id)
    {
        $posts = Post::where('user_id', $id)->get();
        return response([
            'message' => 'Posts Found',
            'data' => $posts
        ], 200);
    }

    public function getUser()
    {
        $user = User::with('posts.getLikeCount', 'posts.getCommentCount')->find(Auth::id());

        return response([
            'message' => 'User Found',
            'data' => $user
        ], 200);
    }

    public function update(UserUpdateValidation $request, $id)
    {
        $request->validated();

        $user = User::find($id);

        if (!$user) {
            return response([
                'message' => 'User Not Found',
            ], 404);
        }

        $user->updateOrCreate(
            [
                'id' => $id
            ],
            [
                'name' => $request['name'],
                'username' => $request['username'],
                'email' => $request['email'],


            ]
        );

        if (!empty($request['password'])) {
            $user->update(['password' => bcrypt($request['password'])]);
        }

        return response([
            'message' => 'User Updated',
            'data' => $user
        ], 200);
    }
}