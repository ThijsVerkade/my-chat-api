<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Message;

Route::group(
    [
        'prefix' => 'v1'
    ],
    static function() {
        Route::prefix('messages')->group(static function() {
            Route::post('/create', Message\Create::class)
                ->name('api.message.post.create');
        });
    }
);
