<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostDeleteRequest;
use App\Http\Requests\Post\PostEditRequest;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Post;
use App\Models\PostUser;
use App\Queries\PostIndexQuery;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = (new PostIndexQuery($request->query('search')))
            ->__invoke()
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();
        $newPost = Post::query()->create($data);

        PostUser::query()->create([
            'post_id' => $newPost->id,
            'user_id' => auth()->id(),
        ]);

        CategoryPost::query()->create([
            'post_id' => $newPost->id,
            'category_id' => $data['category_id'],
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $post->load(['comments.user', 'users', 'category']);

        return view('posts.show', compact('post'));
    }

    public function edit(PostEditRequest $request, Post $post)
    {
        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(PostUpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        $post->update($data);

        return redirect()->route('posts.show', compact('post'))->with('success', 'Post updated successfully.');
    }

    public function destroy(PostDeleteRequest $request, Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
