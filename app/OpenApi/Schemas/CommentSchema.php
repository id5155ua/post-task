<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Comment",
 *     title="Comment",
 *     description="comment к post у",
 *     required={"id", "content", "post_id", "user_id"},
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="content", type="string", example="Это мой comment"),
 *     @OA\Property(property="post_id", type="integer", example=3),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-04T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-04T12:30:00Z"),
 * )
 */
class CommentSchema {}
