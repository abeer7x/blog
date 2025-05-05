<?php

namespace App\Services;
use Throwable;
use App\Models\Post;
class PostService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }
    public function getAllPosts()
    {
        return Post::where('is_published', true)->get();
    }
    public function addPost(array $data){
        try{
            return Post::create($data);
        } catch (Throwable $th){
            
        }
    }

    public function getPost($id)
    {
        $post = Post::where('id', $id)
                    ->where('is_published', true)
                    ->first();
    
        if (!$post) {
            throw new \Exception("Post not found or not published");
        }
    
        return $post;
    }
    

    public function updatePost(array $data , Post $post){
        try {
            $post->update($data);
            return $post;
        } catch(Throwable $th) {
           
        }
    }
    

}
