<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Display a listing of the posts
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->get(); // Only fetch posts of the logged-in user
        return view('posts.index', compact('posts'));
    }

    // Store a newly created post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(), // Associate the post with the logged-in user
        ]);

        return redirect()->route('posts.index');
    }

    public function create()
    {
        return view('posts.create'); // Return the view for creating a new post
    }

    // Display the specified post
    public function show(Post $post)
    {
        $this->authorizePostAccess($post); // Ensure the user owns the post
        return view('posts.show', compact('post'));
    }

    // Show the form for editing the specified post
    public function edit(Post $post)
    {
        $this->authorizePostAccess($post); // Ensure the user owns the post
        return view('posts.edit', compact('post'));
    }

    // Update the specified post
    public function update(Request $request, Post $post)
    {
        $this->authorizePostAccess($post); // Ensure the user owns the post

        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post->update($request->only(['title', 'body']));

        return redirect()->route('posts.index');
    }

    // Remove the specified post
    public function destroy(Post $post)
    {
        $this->authorizePostAccess($post); // Ensure the user owns the post
        $post->delete();
        return redirect()->route('posts.index');
    }

    // Helper method to check post ownership
    private function authorizePostAccess(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
