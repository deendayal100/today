<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

   
Route::get('/', [App\Http\Controllers\HomeController::class, 'homepage'])->name('home');
   
Route::get('/player-account', [App\Http\Controllers\frontend\WebController::class, 'player_account'])->name('player-account');
Route::get('/signup', [App\Http\Controllers\frontend\WebController::class, 'signup'])->name('signup');
Route::get('/signin', [App\Http\Controllers\frontend\WebController::class, 'signin'])->name('signin');
Route::get('/homepage', [App\Http\Controllers\HomeController::class, 'homepage'])->name('homepage');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'homepage'])->name('home');
Route::get('/player-logout', [App\Http\Controllers\HomeController::class, 'player_signout'])->name('player-logout');


Route::get('/frontend-forget-password', [App\Http\Controllers\frontend\WebController::class, 'forget_password'])->name('frontend-forget-password');
Route::post('/reset-password', [App\Http\Controllers\frontend\WebController::class, 'reset_password'])->name('reset-password');
Route::get('/reset-password-page/{id}', [App\Http\Controllers\frontend\WebController::class, 'reset_password_page'])->name('reset-password-page');

Route::get('/player-profile', [App\Http\Controllers\frontend\WebController::class, 'player_profile'])->name('player-profile');
Route::get('/player-fund-management', [App\Http\Controllers\frontend\WebController::class, 'player_fund_management'])->name('player-fund-management');
Route::get('/player-game-history', [App\Http\Controllers\frontend\WebController::class, 'player_game_history'])->name('player-game-history');
Route::get('/select-group', [App\Http\Controllers\frontend\WebController::class, 'select_group'])->name('select-group');
Route::get('/tournament-ante', [App\Http\Controllers\frontend\WebController::class, 'tournament_ante'])->name('tournament-ante');
Route::post('/countdown-group', [App\Http\Controllers\frontend\WebController::class, 'countdown_group'])->name('countdown-group');
Route::post('/group-complete-check', [App\Http\Controllers\frontend\WebController::class, 'group_complete_check'])->name('group-complete-check');
Route::get('/question-screen', [App\Http\Controllers\frontend\WebController::class, 'question_screen'])->name('question-screen');
Route::post('/get-question', [App\Http\Controllers\frontend\WebController::class, 'get_question'])->name('get-question');
Route::post('/player-answer', [App\Http\Controllers\frontend\WebController::class, 'player_answer'])->name('player-answer');
Route::post('/all-players-answer', [App\Http\Controllers\frontend\WebController::class, 'all_players_answer'])->name('all-players-answer');
Route::post('/auto-answer', [App\Http\Controllers\frontend\WebController::class, 'auto_answer'])->name('auto-answer');
////
Route::get('/result-preloader', [App\Http\Controllers\frontend\WebController::class, 'result_preloader'])->name('result-preloader');
Route::get('/hourly-result-preloader', [App\Http\Controllers\frontend\WebController::class, 'hourly_result_preloader'])->name('hourly-result-preloader');
Route::get('/result-page', [App\Http\Controllers\frontend\WebController::class, 'result_page'])->name('result-page');
Route::get('/hourly-result', [App\Http\Controllers\frontend\WebController::class, 'hourly_result'])->name('hourly-result');
Route::post('/hourly-result-page', [App\Http\Controllers\frontend\WebController::class, 'hourly_result_page'])->name('hourly-result-page');
Route::post('/remove-from-group', [App\Http\Controllers\frontend\WebController::class, 'remove_from_group'])->name('remove-from-group');
Route::get('/group-countdown', [App\Http\Controllers\frontend\WebController::class, 'group_countdown'])->name('group-countdown');
Route::get('/countdown-tournament', [App\Http\Controllers\frontend\WebController::class, 'countdown_tournament'])->name('countdown-tournament');
Route::get('/qa-tournament', [App\Http\Controllers\frontend\WebController::class, 'qa_tournament'])->name('qa-tournament');
Route::post('/group-hourly', [App\Http\Controllers\frontend\WebController::class, 'group_hourly'])->name('group-hourly');
Route::post('/tournament-question', [App\Http\Controllers\frontend\WebController::class, 'tournament_question'])->name('tournament-question');
Route::get('/send-invite', [App\Http\Controllers\frontend\WebController::class, 'send_invite'])->name('send-invite');
Route::post('/player-hourly-answer', [App\Http\Controllers\frontend\WebController::class, 'player_hourly_answer'])->name('player-hourly-answer');
//-----frontend start-----//
Route::post('/player-signup', [App\Http\Controllers\frontend\WebController::class, 'player_signup'])->name('player-signup');
Route::post('/player-signin', [App\Http\Controllers\frontend\WebController::class, 'player_signin'])->name('player-signin');
Route::post('/player-profile-detail', [App\Http\Controllers\frontend\WebController::class, 'player_profile_detail'])->name('player-profile-detail');
Route::post('/player-profile-update', [App\Http\Controllers\frontend\WebController::class, 'player_profile_update'])->name('player-profile-update');
Route::post('/active-players', [App\Http\Controllers\frontend\WebController::class, 'active_players'])->name('active-players');
//----admin start---//
Route::post('/user_change_password', [App\Http\Controllers\backend\userController::class, 'user_change_password'])->name('user_change_password'); 
Route::post('/update_admin_profile', [App\Http\Controllers\backend\userController::class, 'update_admin_profile'])->name('update_admin_profile');
Route::get('signout', [App\Http\Controllers\backend\Admin::class, 'signOut'])->name('signout')->middleware('rememberme'); 
//------admin login----// 
Route::get('/admin', [App\Http\Controllers\admin\Admin::class, 'index'])->name('login');
Route::get('/dashboard', [App\Http\Controllers\admin\Admin::class, 'dashboard'])->middleware('rememberme'); 
//---player manage---//
 Route::get('/player_list', [App\Http\Controllers\admin\PlayerController::class, 'index'])->name('player_list')->middleware('rememberme');  
 Route::post('/add_player', [App\Http\Controllers\admin\PlayerController::class, 'storePlayer'])->name('add_player')->middleware('rememberme');
 Route::post('/edit_player', [App\Http\Controllers\admin\PlayerController::class, 'updatePlayer'])->name('edit_player')->middleware('rememberme');
 Route::post('/detail_player', [App\Http\Controllers\admin\PlayerController::class, 'detailPlayer'])->name('detail_player')->middleware('rememberme');
 Route::post('/player/change/status', [App\Http\Controllers\admin\PlayerController::class, 'player_change_Status'])->name('playerchangestatus')->middleware('rememberme');
 Route::get('/player_delete/{id}', [App\Http\Controllers\admin\PlayerController::class, 'delete'])->name('player_delete')->middleware('rememberme');
//---- funds management----// 
 Route::get('/funds_deposit_list', [App\Http\Controllers\admin\FundsController::class, 'index'])->name('funds_deposit_list')->middleware('rememberme');
 Route::get('/funds_widrawl_list', [App\Http\Controllers\admin\FundsController::class, 'widrawl_index'])->name('funds_widrawl_list')->middleware('rememberme');
 Route::post('/funds-widrawl-request-status', [App\Http\Controllers\admin\FundsController::class, 'widrawl_request_status'])->name('funds_widrawl_request_status')->middleware('rememberme');
 //---- record of play ----//
 Route::get('/player-game-list', [App\Http\Controllers\admin\GameController::class, 'index'])->name('player-game-list')->middleware('rememberme');
 Route::get('/game-view/{id}', [App\Http\Controllers\admin\GameController::class, 'show'])->name('game-view')->middleware('rememberme');
 
 Route::get('/group-list', [App\Http\Controllers\admin\RecordController::class, 'group_view'])->name('group-list')->middleware('rememberme');
 Route::get('/tournament-list', [App\Http\Controllers\admin\RecordController::class, 'tournament_view'])->name('tournament-list')->middleware('rememberme');
  //---- Stastics ----//
 Route::get('/player-stastics', [App\Http\Controllers\admin\StasticsController::class, 'index'])->name('player-stastics')->middleware('rememberme');
 //---- Questions Upload ----//
 Route::get('/player-questions', [App\Http\Controllers\admin\QuestionController::class, 'index'])->name('player-questions')->middleware('rememberme');
 Route::post('/upload-questions', [App\Http\Controllers\admin\QuestionController::class, 'upload_csv'])->name('upload-questions')->middleware('rememberme');
//.......Group Play Management ........//
Route::get('/group-ante-amount', [App\Http\Controllers\admin\GameController::class, 'group_ante_amount'])->name('group-ante-amount')->middleware('rememberme');
Route::get('/group-player-no', [App\Http\Controllers\admin\GameController::class, 'group_player_no'])->name('group-player-no')->middleware('rememberme');
Route::post('/update-ante-amount', [App\Http\Controllers\admin\GameController::class, 'update_ante_amount'])->name('update-ante-amount')->middleware('rememberme');
Route::post('/update-player-no', [App\Http\Controllers\admin\GameController::class, 'update_player_no'])->name('update-player-no')->middleware('rememberme');
Route::post('/serach-game-record', [App\Http\Controllers\admin\GameController::class, 'serach_game_record'])->name('serach-game-record')->middleware('rememberme');
Route::get('/hourly-ante-amount', [App\Http\Controllers\admin\GameController::class, 'hourly_ante_amount'])->name('hourly-ante-amount')->middleware('rememberme');
Route::post('/update-hourly-ante-amount', [App\Http\Controllers\admin\GameController::class, 'update_hourly_ante_amount'])->name('update-hourly-ante-amount')->middleware('rememberme');


 
Route::post('store-data', [App\Http\Controllers\backend\userController::class, 'store'])->name('store-data')->middleware('rememberme');
Route::get('/user_view/{id}', [App\Http\Controllers\backend\userController::class, 'userView'])->middleware('rememberme');
Route::get('/user_edit/{id}', [App\Http\Controllers\backend\userController::class, 'edit'])->name('user_edit')->middleware('rememberme');
Route::post('/update_data', [App\Http\Controllers\backend\userController::class, 'updateData'])->middleware('rememberme');
 
Route::get('/user_delete/{id}', [App\Http\Controllers\backend\userController::class, 'delete'])->name('user_delete')->middleware('rememberme');


Route::post('/notification', [App\Http\Controllers\admin\Admin::class, 'notification'])->name('notification');



Route::get('/user-view/{id}', 'App\Http\Controllers\admin\userController@userview');

Route::get('/founds_list', [App\Http\Controllers\admin\userController::class, 'index'])->name('user_list')->middleware('rememberme'); 
Route::get('/user-view/{id}', 'App\Http\Controllers\admin\userController@userview');
Route::post('/changeStatus/{id}', [App\Http\Controllers\admin\userController::class, 'changeStatus'])->name('changeStatus')->middleware('rememberme');
Route::post('/userchangestatus', [App\Http\Controllers\admin\userController::class, 'userchangeStatus'])->name('userchangeStatus')->middleware('rememberme');
Route::post('/userchangestatusactive', [App\Http\Controllers\admin\userController::class, 'userchangestatusactive'])->name('userchangestatusactive')->middleware('rememberme');
Route::get('/user_edit/{id}', [App\Http\Controllers\admin\userController::class, 'edit'])->name('user_edit')->middleware('rememberme');
Route::post('/update_data', [App\Http\Controllers\admin\userController::class, 'updateData'])->middleware('rememberme');
Route::get('/user_delete/{id}', [App\Http\Controllers\admin\userController::class, 'delete'])->name('user_delete')->middleware('rememberme');

Route::post('custom-login', [App\Http\Controllers\backend\Admin::class, 'customLogin'])->name('login.custom'); 

Route::get('/forget-password','App\Http\Controllers\backend\Admin@forget_password');

Route::post('/forgotadminpasswordformcheck', 'App\Http\Controllers\LoginController@forgotadminpasswordformcheck')->name('forgotadminpasswordformcheck');

Route::get('/adminotp-verifictionforget','App\Http\Controllers\LoginController@adminotpverifictionforget');

Route::post('/adminverify_otp', 'App\Http\Controllers\LoginController@adminverify_otp')->name('adminverify_otp');
Route::get('/resend_otp', 'App\Http\Controllers\LoginController@resend_otp');

Route::get('/adminforgetpasswordview/{id}','App\Http\Controllers\LoginController@adminforgetpasswordview');

Route::post('/verify_adminforgetpassword', 'App\Http\Controllers\LoginController@verify_adminforgetpassword')->name('verify_adminforgetpassword');


Route::get('/rewords_list', [App\Http\Controllers\admin\userController::class, 'rewords_list'])->name('rewords_list')->middleware('rememberme'); 

Route::get('/statistics_list', [App\Http\Controllers\admin\userController::class, 'statistics_list'])->name('statistics_list')->middleware('rememberme'); 

Route::get('/my_profile', function () {
   return view('Pages.my_profile');
});


