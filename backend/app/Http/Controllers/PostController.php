<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;

class PostController extends Controller
{
    public function createPost(PostRequest $request)
    {
        $post = new Post;
        $post->createPost($request);
        return response()->json($post, 201);
    }

    public function showPost($id)
    {
        $post = new Post;
        $post = $post->showPost($id);
        return response()->json($post, 200);
    }

    public function listPosts()
    {
        $posts = new Post;
        $posts = $posts->listPosts();
        return response()->json([$posts], 200);
    } 

    public function updatePost(PostRequest $request, $id)
    {
        $post = new Post;
        $post->updatePost($request, $id);
        return response()->json($post, 200);
    }

    public function deletePost($id)
    {
        $Post = new Post;
        $Post->deletePost($id);
        return response()->json("Post ".$id." deletado", 202);
    }
}