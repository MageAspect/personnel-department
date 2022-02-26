<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonResponse(
        $data,
        $code = 200,
        array $headers = array(),
        int $options = JSON_UNESCAPED_UNICODE
    ): JsonResponse {
        return response()->json(
            $data,
            $code,
            $headers,
            $options
        );
    }
}
