<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\postController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/trance', [postController::class, 'trance']);

Route::post('/create', [postController::class, 'create']);

Route::post('/delete', [postController::class, 'delete']);

Route::post('/update', [postController::class, 'update']);

Route::get('/get', [postController::class, 'index']);

Route::post('/naverSearch', [postController::class, 'naverSearch']);

Route::get('/weather', [postController::class, 'weather']);

Route::apiResource('/calendar', 'CalendarController');

Route::post('/kakaopay', [postController::class, 'kakaopay']);

Route::post('/addHouse', [postController::class, 'addHouse'])->middleware('auth:sanctum');

Route::post('/loadHouse', [postController::class, 'loadHouse']);

Route::post('/reserve', [postController::class, 'reserve']);

Route::post('/loadreserve', [postController::class, 'loadreserve']);

Route::get('/chartloadHouse', [postController::class, 'chartloadHouse']);

Route::post('/addReserve', [postController::class, 'addReserve']);

Route::post('/clickHeart', [postController::class, 'clickHeart']);

Route::post('/unClickHeart', [postController::class, 'unClickHeart']);

Route::post('/loadHeart', [postController::class, 'loadHeart']);

Route::post('/loadUserReserve', [postController::class, 'loadUserReserve']);

Route::post('/comment', [postController::class, 'comment']);

Route::get('/commentLoad/{houseId}', [postController::class, 'commentLoad']);

Route::post('/register', [postController::class, 'register']);

Route::post('/login', [postController::class, 'login']);

Route::get('/loadStarChart', [postController::class, 'loadStarChart']);

Route::post('/userHeartLoad', [postController::class, 'userHeartLoad']);

Route::post('/houseSearch', [postController::class, 'houseSearch']);

Route::post('/payment', [postController::class, 'payment']);

Route::post('/masterHouseUpload', [postController::class, 'masterHouseUpload']);

Route::post('/masterReserved', [postController::class, 'masterReserved']);

Route::post('/houseUpdate', [postController::class, 'houseUpdate']);

Route::post('/masterComment', [
    postController::class,
    'masterComment'
]);

Route::post('/reCommentLoad', [postController::class, 'reCommentLoad']);

Route::post('/houseDelete', [postController::class, 'houseDelete']);

Route::post('/isUser', [postController::class, 'isUser']);

Route::post('/userreservedUploads', [postController::class, 'userreservedUploads']);

Route::post('/addpoint', [postController::class, 'addpoint']);

Route::post('/loadPoint', [postController::class, 'loadPoint']);

Route::post('/masterCommentLoad', [postController::class, 'masterCommentLoad']);
