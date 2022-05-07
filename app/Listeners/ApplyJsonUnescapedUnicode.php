<?php

namespace App\Listeners;


use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\JsonResponse;

class ApplyJsonUnescapedUnicode
{
    public function handle(RequestHandled $event): void
    {
        $resp = $event->response;

        if ($resp instanceof JsonResponse) {
            $resp->setEncodingOptions($resp->getEncodingOptions() | JSON_UNESCAPED_UNICODE);
        }
    }
}
