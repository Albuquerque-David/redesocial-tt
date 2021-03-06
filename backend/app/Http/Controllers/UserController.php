<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\CommentPostRequest;
use App\User;
use App\Post;
use App\CommentPost;
use Auth;

class UserController extends Controller
{
    public function createUser(UserRequest $request)
    {
        $user = new User;
        $user->createUser($request);
        return response()->json($user, 201);
    }

    public function confirmAccount($id)
    {
        $user = User::showUser($id);
        $user->confirmAccount($user,$id);
        return redirect('/');
    }

    public function showUser($id)
    {
        $user = User::showUser($id);
        return response()->json($user, 200);
    }

    public function listUsers()
    {
        $users = User::listUsers();
        return response()->json([$users], 200);
    }

    public function updateUser(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->updateUser($request, $id);
        return response()->json($user, 200);
    }

    public function deleteUser($id)
    {
        $user = User::deleteUser($id);
        return response()->json($user, 202);
    }

    public function follow($following_id)
    {
        $follower_id = Auth::user()->id;
        $following = new User;
        $response = $following->follow($following_id, $follower_id);
        return response()->json($response);
    }

    //
    // Funções de posts, comments e likes 
    //

    public function publishPost(PostRequest $request)
    {
        $post = new Post;
        $post->createPost($request);
        return response()->json($post);
    }

    public function commentPost(CommentPostRequest $request)
    {
      $comment = new CommentPost;
      $comment->createCommentPost($request);
      return response()->json($comment);
    }

    public function like($post_id)
    {
        $response = User::like($post_id);
        return response()->json($response);
    }

    public function viewPosts()
    {
        $user = Auth::user();
        $following = $user->following;
        $posts = array();

        foreach ($following as $friend) {
            foreach($friend->posts as $post) {
                array_push($posts, $post);
                $tag = $post->tag;
            }
        }
        
        return response()->json($posts, 200);
    }

    public function getPosts($id) {
        $user = User::showUser($id);
        $posts = $user->posts;
        return response() -> json($posts, 200);
    }

    public function getMyPosts() {
        $auth_user = Auth::user();
        $posts = $user->posts;
        return response() ->json($posts, 200);
    }

    public function getMyFollowers()
    {
        $auth_user = Auth::user();
        $user = User::showUser($auth_user->id);
        $followers = $user->followers;
        return response()->json($followers, 200);
    }

    public function getMyFollowings()
    {
        $auth_user = Auth::user();
        $user = User::showUser($auth_user->id);
        $followings = $user->following;
        return response()->json($followings, 200);
    }

    public function getFollowers($id)
    {
        $user = User::showUser($id);
        $followers = $user->followers;
        return response()->json($followers, 200);
    }

    public function getFollowings($id)
    {
        $user = User::showUser($id);
        $followings = $user->following;
        return response()->json($followings, 200);
    }
}
