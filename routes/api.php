<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EvaluationContoller;

Route::get('/', function () {
    return response()->json(['message' => 'success']);
});

Route::get('/evaluations/{company}', [EvaluationContoller::class, 'index']);
Route::post('/evaluations/{company}', [EvaluationContoller::class, 'store']);
