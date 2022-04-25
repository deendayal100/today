<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

//---------------------------------------start----------------//

//User App
Route::post('/user/register', 'App\Http\Controllers\Api\UserController@userRegister');  // Register User
Route::post('login', 'App\Http\Controllers\Api\UserController@login');   // login
Route::post('profile/update', 'App\Http\Controllers\Api\UserController@update_profile'); // profile update
Route::get('hourly/ante/amount', 'App\Http\Controllers\Api\UserController@hourly_ante_amount'); // get Hourly Ante Amount
Route::get('ante/amount', 'App\Http\Controllers\Api\UserController@ante_amount'); // get Ante Amount
Route::get('player/number', 'App\Http\Controllers\Api\UserController@player_number'); // get player number
Route::post('group/live/players', 'App\Http\Controllers\Api\UserController@active_players'); // get live group
Route::post('add/player/ingroup', 'App\Http\Controllers\Api\UserController@add_player_ingroup'); // add player in group
Route::post('remove/player/fromgroup', 'App\Http\Controllers\Api\UserController@remove_player_fromgroup'); // delete player from group
Route::post('group/complete', 'App\Http\Controllers\Api\UserController@group_complete'); // delete player from group
Route::post('get/question', 'App\Http\Controllers\Api\UserController@get_question'); // get question for player group
Route::post('player/answer', 'App\Http\Controllers\Api\UserController@player_answer'); // player answer
Route::post('all/players/answer', 'App\Http\Controllers\Api\UserController@all_players_answer'); //all player answer
Route::post('play/group/result', 'App\Http\Controllers\Api\UserController@play_group_result'); //group play result
Route::post('game/detail', 'App\Http\Controllers\Api\UserController@game_detail'); // game detail
Route::post('hourly/game/detail', 'App\Http\Controllers\Api\UserController@hourly_game_detail'); // game detail
Route::post('add/player/tournament', 'App\Http\Controllers\Api\UserController@add_player_intournament'); // add player in tournament
Route::post('get/tournament/question', 'App\Http\Controllers\Api\UserController@get_tournament_question'); // add player in tournament
Route::post('player/hourly/answer', 'App\Http\Controllers\Api\UserController@player_hourly_answer'); // player answer



Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'App\Http\Controllers\Api\UserController@details');
    Route::post('player/profile/detail', 'App\Http\Controllers\Api\UserController@profile_details');
});
