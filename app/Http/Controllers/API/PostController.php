<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator; // Add this at the top of your controller

class PostController extends Controller
{
    public function getAllPost():JsonResponse
    {
        try {

            $all_posts = Post::with('user')->get();


            return response()->json([
                'status' => 'success',
                'data' => $all_posts
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Posts not found'
            ], 404);
        }
    }
    public function singlePost($id)
    {
        try {

            $post = Post::with('user')->findOrFail($id);


            return response()->json([
                'status' => 'success',
                'data' => $post
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }
    }
    public function createPost(Request $request)
    {
        try {

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);


            $post = Post::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                 'author_id' => Auth::user()->id, 
               
            ]);


            return response()->json([
                'status' => 'success',
                'data' => $post
            ], 201);
        } catch (ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Validation error: ' . $e->getMessage()
            ], 422);
        }
    }

    public function deletePost($id)
    {
       
        try {
             $post = Post::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
             


            $post->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Post deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found or not authorized'
            ], 404);
        }
    }
    public function updatePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
    
       
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        try {
           
            $post = Post::where('id', $request->post_id)->where('author_id', Auth::user()->id)->firstOrFail();
    
           
            $post->update($validator->validated());
    
           
            return response()->json([
                'status' => 'success',
                'message' => 'Post updated successfully',
                'post' => $post
            ], 200);
    
        } catch (ModelNotFoundException $e) {
           
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found or not authorized'
            ], 404);
        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}
