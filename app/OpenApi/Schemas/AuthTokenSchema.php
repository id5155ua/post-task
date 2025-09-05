<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="AuthToken",
 *     title="AuthToken",
 *     type="object",
 *     description="Successful login / register response",
 *     required={"token"},
 *
 *     @OA\Property(property="user", ref="#/components/schemas/User"),
 *     @OA\Property(
 *         property="token",
 *         type="string",
 *         example="1|laravel_sanctum_example_token",
 *         description="Personal access token (Sanctum, expires in 7 days)"
 *     ),
 * )
 */
class AuthTokenSchema {}
