<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\OpenApi(
     *     @OA\Info(
     *         version="1.0",
     *         title="Simpson Api",
     *         description="Simpson retrieve external Api",
     *     )
     * )
     * @OA\SecurityScheme(
     *        securityScheme="bearerAuth",
     *        in="header",
     *        name="bearerAuth",
     *        type="http",
     *        scheme="bearer",
     *        bearerFormat="JWT",
     *     ),
     */
    use AuthorizesRequests, ValidatesRequests;
}
