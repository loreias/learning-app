<?php


# calling PagesController controller with a index method 
Route::get('/', function ()
{	
	# validate if user is logged in
	if (Auth::check()) return 'Wellcome to the learning app: ' . Auth::user()->name;

	// return link_to('login', 'Login with Google');
	return redirect('login');

});


/**
 * LARAVEL AUTH controllers
 * 
 */


// Authentication routes...

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');


// social users
Route::get('login/{provider}', 'Auth\AuthController@loginWithProvider');


// Registration routes...

Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');


// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');


// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');




/**
 * ADMINISTRATOR
 */
Route::get('admin', 'AdminController@index');





/**
 * REGISTER USERS 
 */
Route::get('profile', 'ProfileController@index');
Route::get('profile/{user}', 'ProfileController@show');
Route::get('profile/{user}/edit', 'ProfileController@edit');




/**
 * Levels  
 */
Route::resource('levels', 'LevelsController');






/**
 * Create Lessons
 *
 * @create
 * @store
 */
Route::get('lessons/create', 'LessonsController@create');
Route::post('lessons', 'LessonsController@store');


/**
 * EDIT LESSONS
 *
 * @edit
 * @update
 * @destroy
 */
Route::get('lessons/{lesson}/edit', 'LessonsController@edit');
Route::put('lessons/{lesson}', 'LessonsController@update');
Route::delete('lessons/{lesson}', 'LessonsController@destroy');
// Route::patch('lessons/{lesson}', 'LessonsController@update');



/**
 * view Lessons
 *
 * @index 	
 * @show
 */
Route::get('{level}/lessons/', 'LessonsController@index');
Route::get('{level}/lessons/{lesson}', 'LessonsController@show');







/*
|-----------------
| MY NOTES:
|-----------------
|
*/





/**
* levels 			-> route: url string 
* LevelsController 	-> controller class name
* index 			-> mothod name to call inside the controller class 	
*/
// Route::get('levels', 'LevelsController@index');


/**
* display the create form
*/
// Route::get('levels/create', 'LevelsController@create');



/**
* pass the id of the level to load*
*/
// Route::get('levels/{id}', 'LevelsController@show');



/**
 * add new Levels to the db
 */
// Route::post('levels', 'LevelsController@store');



/**
 * edit selected level
 */
// Route::get('levels/{id}/edit', 'LevelsController@edit'); 




/* laravel route auth 4.2
Route::controllers([
	'auth' 		=> 'Auth\AuthController',
	'password'	=> 'Auth\PasswordController', 
]);
*/