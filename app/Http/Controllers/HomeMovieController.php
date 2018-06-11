<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Support\Facades\DB;

class HomeMovieController extends Controller
{
    public function getMovies(){
        $movies = DB::connection('sakila')->table('film')
        ->leftjoin('film_actor', 'film.film_id', '=', 'film_actor.film_id')
        ->leftjoin('actor', 'film_actor.actor_id', '=', 'actor.actor_id')
        ->leftjoin('film_category', 'film_category.film_id', '=', 'film.film_id')
        ->leftjoin('category', 'film_category.category_id', '=', 'category.category_id')
        ->groupBy('film.title', 'film.release_year', 'category.category_id')
        ->select('film.title', 'film.release_year as releaseDate', 'category.name')
        ->selectRaw('GROUP_CONCAT(CONCAT(actor.first_name, " ", actor.last_name)) as actors, film.rental_rate as rating')
        ->orderBy('rating', 'DESC')
        ->take(5)
        ->get();

        return view('home')->with('movies', $movies);

    }
}
