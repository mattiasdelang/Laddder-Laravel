<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	if (Auth::check()) {
            return redirect('/homepage');
    }
    return view('welcome');
});

Route::get('/register','UsersController@register');
Route::post('/register','Auth\AuthController@postRegister');

Route::get('/activity','ProjectsController@showActivity');

Route::get('/achievements','AchievementsController@showAchievements');

Route::get('/apikey','UsersController@showApikey');

Route::get('/referfriend','UsersController@showReferfriend');
Route::post('/referfriend','UsersController@inviteFriend');

Route::get('/changepw','UsersController@changePW');
Route::post('/changepw','UsersController@changePWPost');

Route::get('/user/profile/{id}','UsersController@profile');

Route::get('/user/edit-profile','UsersController@editProfile');
Route::post('/user/edit-profile','UsersController@editProfileUser');

Route::get('/login','UsersController@login');
Route::post('/login','UsersController@loginPost');
Route::get('/logout', 'Auth\AuthController@getLogout');

Route::get('/homepage','UsersController@home');

Route::post('/search','SearchController@search');
Route::get('/search','SearchController@view');

Route::get('/create','ProjectsController@create');
Route::post('/create','ProjectsController@store');

Route::get('projects/{id}', 'ProjectsController@projectDetail');
Route::post('projects/{id}/delete', 'ProjectsController@deleteProject');
Route::get('projects/{id}/edit', 'ProjectsController@showEditProject');
Route::post('projects/{id}/edit', 'ProjectsController@editProject');
Route::get('projects/tag/{tag}','ProjectsController@tagProjects');

Route::get('/myLikes','ProjectsController@myLikes');

Route::post('/like','ProjectsController@like');
Route::post('/dislike','ProjectsController@dislike');

Route::post('/comment','ProjectsController@comment');

Route::post('/flag', 'ProjectsController@flag');

Route::get('/challenge/create','ChallengeController@create');
Route::post('/challenge/create','ChallengeController@createPost');

Route::get('/challenge/{id}','ChallengeController@showChallenge');
Route::post('/challenge','ChallengeController@participate');

Route::get('/challenge/{id}/entries','ChallengeController@showEntries');

Route::post('/challenge/vote','ChallengeController@vote');
Route::post('/challenge/unvote','ChallengeController@unvote');

Route::get('/ads/create','AdController@show');
Route::post('/ads/create','AdController@create');

Route::get('/ads/success','AdController@success');


Route::group(array('prefix' => 'api/v1'), function()
{
    Route::get('/items/popular/{apikey}/{page?}/{perpage?}', 'ApiController@popular');
    Route::get('projects/{id}/{apikey}', 'ApiController@project');
});

Route::post('/seennoti','ProjectsController@seenNotification');

Route::get('/followers', 'FollowerController@getIndex');

Route::get('/followers/add/{username}', [
	'uses' => 'FollowerController@getFollow',
	'as' => 'follower.add',
	'middleware' => ['auth'],
	]);



