<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */

namespace App\Exceptions;


use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;


class JsonHttpResponseException extends HttpResponseException
{
    public function __construct(
        string|array $errors,
        $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $headers = array()
    ) {
        if (is_string($errors)) {
            $errors = array($errors);
        }

        parent::__construct(response()->json(
            array('errors' => $errors),
            $code,
            $headers,
            JSON_UNESCAPED_UNICODE
        ));
    }
}
