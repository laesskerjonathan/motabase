<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Support\Facades\DB;

class getActorsHome extends Controller
{
    public function getActors(Request $request){


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

        $actors = DB::connection('sakila')->table('actor')
        ->leftjoin('film_actor', 'film_actor.actor_id', '=', 'actor.actor_id')
        ->leftjoin('film', 'film.film_id', '=', 'film_actor.film_id')
        ->groupBy('actor.first_name', 'actor.last_name')
        ->selectRaw('CONCAT(actor.first_name, " ", actor.last_name) as name,GROUP_CONCAT(film.title) as movies')
        ->orderBy('name', 'ASC')
        ->skip($offset)
        ->take($limit)
        ->get();
        
        if($request->ajax()) {
            return json_encode($actors);
        }


        return view('actors')->with('actors', $actors);
    }

}
