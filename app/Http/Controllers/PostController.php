<?php

namespace App\Http\Controllers;
use App\Services\PostService;
use App\Models\Post;
use App\Http\Requests\Post\storePostRequest;
use App\Http\Requests\Post\UpdateRequest;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource 
     */
    public function index()
    {
        $posts = $this->postService->getAllPosts();

        if ($posts->isNotEmpty()) {
            return $this->success($posts);
        }

        return $this->error("No posts to show", 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storePostRequest $request)
    {
        return $this->success($this->postService->addPost($request->validated()));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $post = $this->postService->getPost($id);
            return $this->success($post);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Post $post)
    {
        return $this->success(
            $this->postService->UpdatePost($request->validated(),$post));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->success(['message'=>'delete}'],200);
    }
}
