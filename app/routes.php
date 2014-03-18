<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@home');
Route::get('/users', 'UserController@get');
Route::get('/categories', 'CategoryController@get');
Route::get('/questions', 'QuestionController@get');
Route::get('/answers', 'AnswerController@get');
Route::post('/login', 'HomeController@login');
Route::get('/logout', 'HomeController@logout');
Route::get('/my_mentor/{mentor_id}', 'UserController@getMyMentor');
Route::get('/my_mentee', 'UserController@getMyMentee');
Route::get('/my_profile', 'UserController@myProfile');
Route::get('/dashboard', 'HomeController@home');
Route::post('/saveProfile', 'UserController@saveProfile');
Route::get('/question-and-answer', 'HomeController@getQandA');
Route::get('/question/{id}', 'QuestionController@details');
Route::get('/close-question/{id}/{to}', 'QuestionController@close');
Route::get('/locale/{lang}', 'HomeController@changeLocale');
Route::get('/ask-a-question', 'QuestionController@ask');
Route::post('/save-question', 'QuestionController@save');
Route::post('/save-answer', 'AnswerController@save');
Route::get('/delete-user/{id}', 'UserController@deleteUser');
Route::get('/create-new-account', 'UserController@newAccount');
Route::post('/new-account-save', 'UserController@newAccountSave');
Route::get('/account/{id}', 'UserController@account');
Route::post('/save-account', 'UserController@accountSave');



// API

// checking api key...
/*
Route::before(
	function() {
		if (Request::header('apikey') != "put a password for your api") {
			return Response::json(array('result' => 'Authentication failed!'), 401);
		}
	}
);
*/

// users
Route::get('/api/users', 'UserController@apiGet');
Route::get('/api/users/{id}', 'UserController@apiGetOne');
Route::post('/api/users', 'UserController@apiPost');
Route::delete('/api/users', 'UserController@apiDelete');
Route::put('/api/users', 'UserController@apiPut');
Route::get('/api/users/{id}/mentor', 'UserController@apiGetMentor');
Route::get('/api/users/{id}/mentee', 'UserController@apiGetMentee');

// questions
Route::get('/api/questions', 'QuestionController@apiGet');
Route::get('/api/questions/{id}', 'QuestionController@apiGetOne');
Route::post('/api/questions', 'QuestionController@apiPost');
Route::delete('/api/questions', 'QuestionController@apiDelete');
Route::put('/api/questions', 'QuestionController@apiPut');
Route::get('/api/questions/{id}/close', 'QuestionController@apiClose');

// answers
Route::get('/api/answers', 'AnswerController@apiGet');
Route::get('/api/answers/{id}', 'AnswerController@apiGetOne');
Route::post('/api/answers', 'AnswerController@apiPost');
Route::delete('/api/answers', 'AnswerController@apiDelete');
Route::put('/api/answers', 'AnswerController@apiPut');
