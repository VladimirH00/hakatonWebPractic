<?php

use App\Http\Controllers\RatingController;
use App\Http\Controllers\TeamsController;
use App\Http\Middleware\UserTokenAuth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('teams/slides', [TeamsController::class, 'getSlides']);
Route::get('rating/types', [RatingController::class, 'getRatingTypes']);
Route::get('rating/teams', [RatingController::class, 'getRatingAll']);
Route::post('team/login', [TeamsController::class, 'login']);
Route::post('team/register', [TeamsController::class, 'register']);

Route::middleware([UserTokenAuth::class])->group(function () {


});
