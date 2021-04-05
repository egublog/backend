<?php

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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','Auth\RegisterController@showRegistrationForm')->name('signup.get');

Route::post('signup','Auth\RegisterController@register')->name('signup.post');

Route::get('/players/people/home', 'PeopleController@home');


Route::get('/players/people/profile', 'PeopleController@profile');

Route::post('/players/second/profile_store', 'SecondController@profile_store');
Route::get('/players/second/profile_store', 'SecondController@profile_store_error');

// Route::get('/image_form', 'SecondController@image_form');


Route::post('/players/second/image_store', 'SecondController@image_store');
Route::get('/players/second/image_store', 'SecondController@image_store_error');




Route::get('/players/people/activity', 'PeopleController@activity');

Route::get('/players/people/friend_follower', 'PeopleController@friend_follower');

Route::get('/players/people/friend_follow', 'PeopleController@friend_follow');

// Route::get('/players/people/details/{user_id}/{link}', 'PeopleController@details');
Route::post('/players/people/details', 'PeopleController@details');



Route::post('/players/second/follow_switch_details', 'SecondController@follow_switch_details');


Route::post('/players/second/follow_switch_list', 'SecondController@follow_switch_list');




Route::get('/players/second/find', 'PeopleController@find');

Route::post('/players/second/find_return', 'SecondController@find_return');
Route::get('/players/second/find_return', 'SecondController@find_return');




Route::get('/players/people/talk', 'PeopleController@talk');
Route::post('/players/people/talk', 'PeopleController@talk');

Route::post('/players/people/talk_show', 'PeopleController@talk_show');
// Route::get('/players/people/talk_show', 'PeopleController@talk_show');

Route::post('/players/people//talk_store', 'SecondController@talk_store');
// Route::get('/players/people//talk_store', 'SecondController@talk_store');






Route::get('/players/people/back', 'PeopleController@back');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
