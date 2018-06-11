<?php

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

Route::get('/search', function () {
    return view('search');
});

Route::get('/movie', 'MovieController@getMovie');

Route::get('/movies', 'getMoviesHome@getMovies');

Route::get('/actor', 'ActorController@getActor');

Route::get('/actors', 'getActorsHome@getActors');

Route::get('/watchlist', function () {
    return view('watchlist');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/registration', function () {
    return view('registration');
});

Auth::routes();

Route::get('/', 'HomeMovieController@getMovies');

Route::get('/home', 'HomeController@index');

Route::get('/search', [
    'as' => 'search',
    'uses' => 'SearchController@getMovies'
]);

Route::post('/review/submit', 'ReviewController@submitReview');