<?php

use App\Http\Controllers\AxiosController;
use App\Http\Controllers\BackController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Talk_peopleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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


Route::get('/', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');

Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');



Auth::routes();

Route::middleware('auth')->group(function () {


  Route::get('/home', 'HomeController@index')->name('home');


  Route::post('/axios/logout', 'AxiosController@logout')
    ->name('axios.logout');


  // MyhomeController
  Route::resource('myhomes', 'MyhomeController')->only([
    'index'
  ]);


  // ProfileController
  Route::resource('profiles', 'ProfileController')->only([
    'index', 'update', 'show'
  ])->parameters([
    'profiles' => 'user'
  ]);


  // ImageController
  Route::resource('images', 'ImageController')->only([
    'update', 'show'
  ])->parameters([
    'images' => 'user'
  ]);


  // FindController
  Route::resource('finds', 'FindController')->only([
    'index'
  ]);


  // ResultController
  Route::resource('results', 'ResultController')->only([
    'index', 'show'
  ])->parameters([
    'results' => 'user'
  ]);


  // ActivityController
  Route::resource('activities', 'ActivityController')->only([
    'index', 'show'
  ])->parameters([
    'activities' => 'user'
  ]);


  // FriendController
  Route::resource('friends', 'FriendController')->only([
    'index', 'show'
  ])->parameters([
    'friends' => 'user'
  ]);


  // Talk_userController
  Route::resource('talk_users', 'Talk_userController')->only([
    'index', 'show'
  ])->parameters([
    'talk_users' => 'user'
  ]);


  // Talk_userContentController
  Route::get('/talk_users/{user}/contents/axios/userChange', 'Talk_userContentController@axios_userChange')->name('talk_users.contents.axios_userChange');

  Route::get('/talk_users/{user}/contents/axios/talkUpdate', 'Talk_userContentController@axios_talkUpdate')->name('talk_users.contents.axios_talkUpdate');

  Route::resource('talk_users.contents', 'Talk_userContentController')->only([
    'index', 'store'
  ])->parameters([
    'talk_users' => 'user'
  ]);


  Route::resource('follows', 'FollowController')->only([
    'store', 'destroy'
  ])->parameters([
    'follows' => 'user'
  ]);


  // BackController
  Route::get('backs/from_details', 'BackController@fromDetails')
    ->name('backs.from_details');

  Route::get('backs/from_talk_show', 'BackController@fromTalk_show')
    ->name('backs.from_talk_show');
    
});
