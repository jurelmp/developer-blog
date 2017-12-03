<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Protected api routes
 */
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'posts' => 'PostController',
        'posts.comments' => 'CommentController'
    ]);
    Route::get('profile', 'ProfileController@show')->name('profile.show');
    Route::post('profile', 'ProfileController@update')->name('profile.update');
});

