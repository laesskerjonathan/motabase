@extends('layouts.app')

@section('content')
    <?php
        $movies = $results["movies"];
        $actors = $results["actors"];
    ?>
    <h1>Search-Results</h1>
    <p>These Items were found</p>
    <h3>Movies</h3>
    @if(count($movies) > 0)
        @foreach($movies as $movie)
            <ul class="list-group search-results" style="margin-top: 1em; margin-bottom: 1em">
                <li class="list-group-item">
                    <a href="/movie?title={{$movie->title}}">
                        {{ucwords(strtolower($movie->title))}}
                    </a>
                </li>
                <li class="list-group-item">{{$movie->description}}</li>
            </ul>
        @endforeach
    @else 
        <p>No Movies found!</p>
    @endif
    <h3>Actors</h3>
    @if(count($actors) > 0)
        @foreach($actors as $actor)
            <ul class="list-group search-results" style="margin-top: 1em; margin-bottom: 1em">
                <li class="list-group-item">
                    <a href="/actor?name={{$actor->first_name." ".$actor->last_name}}">
                        {{ucwords(strtolower($actor->first_name." ".$actor->last_name))}}
                    </a>
                </li>
            </ul>
        @endforeach
    @else 
        <p>No Actors found!</p>
    @endif
@endsection
