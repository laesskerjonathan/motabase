<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function getMovies(Request $request){

        $search = $request->search;
        $movies = DB::connection('sakila')->table('film')
        ->leftjoin('film_text', 'film_text.film_id', '=', 'film.film_id')
        ->where('film_text.description', 'LIKE', '%'.$search.'%')
        ->orWhere('film.title', 'LIKE', '%'.$search.'%')
        ->select('film.title', 'film_text.description')
        ->orderBy('film.title', 'ASC')
        ->get();

        $actors = DB::connection('sakila')->table('actor')
        ->where('actor.first_name', 'LIKE', '%'.$search.'%')
        ->orWhere('actor.last_name', 'LIKE', '%'.$search.'%')
        ->select('actor.first_name', 'actor.last_name')
        ->orderBy('actor.first_name', 'ASC')
        ->get();

        $results = [
            "movies" => $movies,
            "actors" => $actors
        ];

        return view('search')->with('results', $results);

    }

}
