<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Department;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 📋 List posts
    public function index()
    {
        $posts = Post::with('department')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    // ➕ create form
    public function create()
    {
        $departments = Department::all();
        return view('posts.create', compact('departments'));
    }

    // 💾 store post
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:posts,name',
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
        ]);

        Post::create([
            'name' => $request->name,
            'description' => $request->description,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post créé avec succès');
    }

    // ✏️ edit
    public function edit(Post $post)
    {
        $departments = Department::all();
        return view('posts.edit', compact('post', 'departments'));
    }

    // 🔄 update
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:posts,name,' . $post->id,
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
        ]);

        $post->update([
            'name' => $request->name,
            'description' => $request->description,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post mis à jour');
    }

    // ❌ delete
    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post supprimé');
    }
}