<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::prefix('members')->group(function () {
    Route::get('/', [MemberController::class, 'index']);
    Route::post('/', [MemberController::class, 'store']);
    Route::get('/{member}', [MemberController::class, 'show']);
    Route::patch('/{member}', [MemberController::class, 'update']);
    Route::delete('/{member}', [MemberController::class, 'destroy']);

    Route::post('/{member}/image/upload', [MemberController::class, 'uploadImage']);
    Route::post('/{member}/image/delete', [MemberController::class, 'deleteImage']);
});
