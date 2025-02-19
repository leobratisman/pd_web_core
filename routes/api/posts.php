<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::post('/', [PostController::class, 'store']);
    Route::get('/{post}', [PostController::class, 'show']);
    Route::patch('/{post}', [PostController::class, 'update']);
    Route::delete('/{post}', [PostController::class, 'destroy']);

    Route::post('/{post}/image/upload', [PostController::class, 'uploadImage']);
    Route::post('/{post}/image/delete', [PostController::class, 'deleteImage']);
});
