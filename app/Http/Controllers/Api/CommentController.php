<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Comments",
 *     description="Managing comments on posts"
 * )
 */
class CommentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/comments",
     *     summary="List of Comments",
     *     tags={"Comments"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of Comments",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Comment")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return CommentResource::collection(
            Comment::with(['user'])->latest()->paginate(10)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/comments",
     *     summary="Create a comment",
     *     tags={"Comments"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"post_id", "content"},
     *
     *             @OA\Property(property="post_id", type="integer", example=3),
     *             @OA\Property(property="content", type="string", example="My comment on the post")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Comment created",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'post_id' => $data['post_id'],
            'user_id' => Auth::id(),
            'content' => $data['content'],
        ]);

        return response()->json($comment, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/comments/{id}",
     *     summary="Update comment",
     *     tags={"Comments"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID comment",
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"content"},
     *
     *             @OA\Property(property="content", type="string", example="Updated comment text")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="comment updated",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *
     *     @OA\Response(response=403, description="There's no right"),
     *     @OA\Response(response=404, description="comment not found")
     * )
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $data = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($data);

        return response()->json($comment);
    }

    /**
     * @OA\Delete(
     *     path="/api/comments/{id}",
     *     summary="Delete comment",
     *     tags={"Comments"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID comment",
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(response=204, description="comment deleted"),
     *     @OA\Response(response=403, description="There's no right"),
     *     @OA\Response(response=404, description="comment not found")
     * )
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(null, 204);
    }
}
