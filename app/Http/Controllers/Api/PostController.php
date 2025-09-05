<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostDeleteRequest;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="Post management"
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="List of posts searchable by title",
     *     tags={"Posts"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of posts",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Post")),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Post::query();

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        return $query->latest()->paginate(10);
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a post",
     *     tags={"Posts"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *
     *             @OA\Property(property="title", type="string", example="New post"),
     *             @OA\Property(property="content", type="string", example="Text of the new post"),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="The post was created",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();

        $post = Post::query()->create($data);

        $post->users()->attach(Auth::id());

        CategoryPost::query()->create([
            'category_id' => $data['category_id'],
            'post_id' => $post->id,
        ]);

        return response()->json($post, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Show post ",
     *     tags={"Posts"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID post",
     *         required=true,
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Post information",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *
     *     @OA\Response(response=404, description="The post not found")
     * )
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update post ",
     *     tags={"Posts"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID post",
     *         required=true,
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *
     *             @OA\Property(property="title", type="string", example="updatedн post"),
     *             @OA\Property(property="content", type="string", example="updatedное content"),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="The post updated",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *
     *     @OA\Response(response=403, description="There's no right"),
     *     @OA\Response(response=404, description="The post not found")
     * )
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        if (! $post->isAuthor(Auth::user())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validated();

        $post->update($data);
        CategoryPost::query()
            ->where('post_id', $post->id)
            ->update([
                'category_id' => $data['category_id'],
                'post_id' => $post->id,
            ]);

        return response()->json($post);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete post",
     *     tags={"Posts"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID post",
     *         required=true,
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(response=204, description="The post deleted"),
     *     @OA\Response(response=403, description="There's no right"),
     *     @OA\Response(response=404, description="The post not found")
     * )
     */
    public function destroy(PostDeleteRequest $request, Post $post)
    {
        if (! $post->isAuthor(Auth::user())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $post->delete();

        return response()->json(null, 204);
    }
}
