<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActorController extends Controller
{
    public function getActor(Request $request){

        $name = $request->name;
        $first_name = explode(' ', $name)[0];
        $last_name = explode(' ', $name)[1];

        Log::info('Getting Actor with name: '.$first_name.' '.$last_name);

        $actor = DB::connection('sakila')->table('actor')
        ->leftjoin('film_actor', 'film_actor.actor_id', '=', 'actor.actor_id')
        ->leftjoin('film', 'film.film_id', '=', 'film_actor.film_id')
        ->leftjoin('film_category', 'film_category.film_id', '=', 'film.film_id')
        ->leftjoin('category', 'film_category.category_id', '=', 'category.category_id')
        ->where([
            ['actor.first_name', '=', $first_name],
            ['actor.last_name', '=', $last_name]])
        ->groupBy('actor.first_name', 'actor.last_name')
        ->select('actor.first_name', 'actor.last_name')
        ->selectRaw('GROUP_CONCAT(CONCAT(category.name, ";", film.title, ";", film.rental_rate, ";", film.release_year)) as movies')
        ->get();



        $reviews = DB::table('reviews')
        ->where('reviews.title', '=', $name)
        ->orderBy('updated_at', 'ASC')
        ->get();

        $response = [
            'actor' => $actor,
            'reviews' => $reviews
        ];

        return view('actor')->with('response', $response);

    }
}
