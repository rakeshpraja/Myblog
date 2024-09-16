<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {

        return view('create_blog');
    }
    public function addPost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'title.required' => 'The title field is mandatory.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title cannot be longer than 255 characters.',
            'content.required' => 'Content is required.',
            'content.string' => 'Content must be a string.',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->author_id = Auth::user()->id;
        $post->save();


        return response()->json([
            'success' => true,
            'message' => 'Post created successfully!',
            'post' => $post
        ]);
    }
    public function singlePost($id)
    {
        $single_post = Post::find($id);

        return view('single_post', compact('single_post'));
    }
    public function blogList()
    {
        $all_post = Post::get();
        return view('all_blog', compact('all_post'));
    }
    public function editPost($id)
    {
        $edit_post = Post::find($id);
        return view('edit_blog', compact('edit_post'));
    }
    public function updatePost(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content must be a string.',
        ]);


        $post = Post::findOrFail($id);
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->save();


        return response()->json(['success' => true, 'message' => 'Post updated successfully!']);
    }
    public function deletePost($id)
    {
        $post = Post::find($id);
    
        if ($post) {
            $post->delete(); // Delete the post from the database
    
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post not found!'
            ], 404);
        }
    }
    
}
