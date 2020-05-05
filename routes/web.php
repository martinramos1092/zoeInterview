<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/main', 'MainController@index');
//Route::view('/main/register', 'register');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::post('/main/successregistration', 'MainController@successregistration');
Route::post('/main/successedit/{id}', 'MainController@successedit');
Route::post('/main/deleteuser/{id}', 'MainController@deleteuser');
Route::post('/main/edituser/{id}', 'MainController@edituser');
Route::get('main/successlogin', 'MainController@successlogin');
Route::get('main/logout', 'MainController@logout');
Route::get('main/register', 'MainController@register');
Route::get('main/syncContacts', 'MainController@synccontact');
Route::get('main/search', 'MainController@search');


