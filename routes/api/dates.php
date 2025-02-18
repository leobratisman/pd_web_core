<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;

Route::prefix('dates')->group(function () {
    Route::get('/', [DateController::class, 'index']);
    Route::post('/', [DateController::class, 'store']);
    Route::get('/{date}', [DateController::class, 'show']);
    Route::patch('/{date}', [DateController::class, 'update']);
    Route::delete('/{date}', [DateController::class, 'destroy']);
});
