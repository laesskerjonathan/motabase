<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class getMoviesHome extends Controller
{
    public function getMovies(Request $request){
        if($request->has('offset')) {
            $offset = $request->offset;
        } else {
            $offset = 0;
        }
        if($request->has('offset')) {
            $limit = $request->limit;
        } else {
            $limit = 5;
        }

        Log::info('Getting Movies with Offset: '.$offset.', Limit '.$limit);

        $movies = DB::connection('sakila')->table('film')
        ->leftjoin('film_actor', 'film.film_id', '=', 'film_actor.film_id')
        ->leftjoin('actor', 'film_actor.actor_id', '=', 'actor.actor_id')
        ->leftjoin('film_category', 'film_category.film_id', '=', 'film.film_id')
        ->leftjoin('category', 'film_category.category_id', '=', 'category.category_id')
        ->groupBy('film.title', 'film.release_year', 'category.category_id')
        ->select('film.title', 'film.release_year as releaseDate', 'category.name')
        ->selectRaw('GROUP_CONCAT(CONCAT(actor.first_name, " ", actor.last_name)) as actors')
        ->orderBy('film.title', 'ASC')
        ->skip($offset)
        ->take($limit)
        ->get();

        if($request->ajax()) {
            return json_encode($movies);
        }



        return view('movies')->with('movies', $movies);

    }


}
