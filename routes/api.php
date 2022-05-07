<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */

use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\MessageController;
use Illuminate\Support\Facades\Route;

Route::apiResource('chat', ChatController::class);
Route::apiResource('chat.message', MessageController::class)->shallow();
