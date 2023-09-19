<?php

use Carbon\Carbon;
use App\Mail\RespondMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\EmailVerController;
use App\Http\Controllers\CoachRequestController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/check/code' , [EmailVerController::class , 'checkCode']) ;


Route::middleware('player.middleware')->post('/player/register' , [PlayerController::class , 'playerRegister']);

Route::middleware('player.auth')->group(function () {
Route::post('/player/search/coach'  , [CoachController::class , 'searchByName']) ;
Route::get('/player/addCup'         , [Controller::class, 'addCup']);
Route::get('/player/removeCup'      , [Controller::class, 'removeCup']);
Route::post('/updateplayerProfile/{id}'  , [PlayerController::class , 'update']);
Route::post('/player/complaint'       , [PlayerController::class, 'store']);
Route::post('/player/food/search' , [Controller::class , 'searchFood']);
Route::post('/player/food/info' ,   [Controller::class , 'getFoodInfo']);
Route::post('/player/food/add' ,    [Controller::class , 'addFood']);
Route::post('/player/requestprogram' , [PlayerController::class, 'programRequest']);
Route::get('/player/viewcoachbyrate' , [CoachController::class ,'viewTopRatedCoaches']);
Route::get('/player/viewallcoach' , [CoachController::class ,'viewAllCoaches']);
Route::get('player/viewcoachProfile/{id}', [CoachController::class , 'show']);
// all the accepted request with coach info
Route::get('/player/viewallprogramrequest' , [PlayerController::class ,'viewAllProgramRequest']);
// just the programs 
Route::get('/player/viewpersonalprograms' , [PlayerController::class ,'viewPersonalPrograms']);
// view daily value
Route::get('/player/viewdailyvalue'  , [Controller::class, 'viewDailyValue']);

Route::get('/playerProfile/{id}'  , [PlayerController::class , 'show']);
Route::post('/player/rate/{id}'          , [PlayerController::class , 'updateTrainerRating']);
});
Route::post('/player/login'       , [PlayerController::class, 'login']);

Route::post('/player/logout'      , function (Request $request) {
    $request->player()->tokens()->delete();
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::middleware('coach.middleware')->post('/coach/register'     , [CoachRequestController::class , 'coachRegister']);

Route::middleware('coach.auth')->group(function () {
Route::get('coach/findplayer' , [PlayerController::class, 'findPlayer']);
Route::get('/coach/addCup'         , [Controller::class, 'addCup']);
Route::get('/coach/removeCup'      , [Controller::class, 'removeCup']);
Route::post('/updatecoachProfile/{id}'  , [coachController::class , 'update']);
Route::post('/coach/food/search' , [Controller::class , 'searchFood']);
Route::post('/coach/food/info' ,   [Controller::class , 'getFoodInfo']);
Route::post('/coach/food/add' ,    [Controller::class , 'addFood']);
Route::get('/coach/viewprogramrequest' , [coachController::class , 'viewProgramRequest']);
Route::get('/coach/rejectprogramrequest' , [coachController::class , 'rejectProgramRequest']);
Route::get('/coach/acceptprogramrequest' , [coachController::class , 'acceptProgramRequest']);
Route::post('/coach/createprogram' , [coachController::class , 'createProgram']);
Route::get('/coach/viewsubscriber' , [coachController::class , 'viewAllSubscriber']);
Route::get('/coach/viewdailyvalue'  , [Controller::class, 'viewDailyValue']);
Route::post('/coach/status', [CoachController::class, 'updateStatus']);
Route::get('/coachProfile/{id}', [CoachController::class , 'show']);
Route::post('/coach/complaint'       , [CoachController::class, 'store']);
});
Route::post('/coach/login'        , [CoachController::class, 'login']);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::post('/admin/login'        , [AdminController::class, 'login']);

Route::middleware('admin.auth')->group(function () {
Route::get('/admin/view/allcoachrequest' , [AdminController::class , 'viewAllJoiningRequest']);
Route::post('/admin/accept/coach' , [AdminController::class , 'acceptRequest']);
Route::post('/admin/reject/coach' , [AdminController::class , 'rejectRequest']);
Route::get('/admin/freezing/coach'   , [AdminController::class , 'freezingCoach']);
Route::get('/admin/freezing/player'  , [AdminController::class , 'freezingPlayer']);
Route::get('/admin/complaints', [AdminController::class, 'showcomplaint']);
Route::get('/admin/complaints/{id}', [AdminController::class, 'showcomplaintid']);
Route::get('/admin/viewallcoaches', [AdminController::class, 'viewAllCoaches']);
Route::get('/admin/viewallplayers' , [AdminController::class, 'viewAllPlayers']);
Route::get('admin/viewcoachProfile/{id}', [CoachController::class , 'show']);
Route::get('admin/findplayer/{id}' , [PlayerController::class, 'findPlayer']);

});

Route::get('send/notification'  , [Controller::class , 'sendNotification']);


