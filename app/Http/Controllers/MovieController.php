<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    public function getMovie(Request $request){

        $title = $request->title;


        Log::info('Getting Movie with Title: '.$title);

        $movie = DB::connection('sakila')->table('film')
        ->leftjoin('film_actor', 'film.film_id', '=', 'film_actor.film_id')
        ->leftjoin('actor', 'film_actor.actor_id', '=', 'actor.actor_id')
        ->leftjoin('film_category', 'film_category.film_id', '=', 'film.film_id')
        ->leftjoin('category', 'film_category.category_id', '=', 'category.category_id')
        ->leftjoin('film_text', 'film_text.film_id', '=', 'film.film_id')
        ->where('film.title', '=', $title)
        ->groupBy('film.title', 'film.release_year', 'category.category_id', 'film.rental_rate', 'film_text.description')
        ->select('film.title', 'film.release_year as releaseDate', 'category.name', 'film.rental_rate as rating', 'film_text.description')
        ->selectRaw('GROUP_CONCAT(CONCAT(actor.first_name, " ", actor.last_name)) as actors')
        ->orderBy('film.title', 'ASC')
        ->get();

        $reviews = DB::table('reviews')
        ->where('reviews.title', '=', $title)
        ->orderBy('updated_at', 'ASC')
        ->get();

        $response = [
            'movie' => $movie,
            'reviews' => $reviews
        ];

        return view('movie')->with('response', $response);

    }

}
