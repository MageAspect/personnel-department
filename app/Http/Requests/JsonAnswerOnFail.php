<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;


trait JsonAnswerOnFail
{
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                array('errors' => $errors),
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
