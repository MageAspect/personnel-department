<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index(int $chatId)
    {
    }

    public function show(int $messageId)
    {
        \App\Events\ChatMessageStored::dispatch($messageId);
    }

    public function store(int $chatId)
    {

    }

    public function update(int $messageId)
    {

    }

    public function destroy(int $messageId)
    {

    }
}
