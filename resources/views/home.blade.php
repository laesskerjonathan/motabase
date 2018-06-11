@extends('layouts.app')

@section('content')
    <h1>Home</h1>
    <h1>5 All-Time Best Movies</h1>
    <p>Here are all the movies.</p>
        <table id="moviesPageOverviewTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Actors</th>
                    <th>Category</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($movies as $movie)
                <tr>
                    <td>
                        <a href="/movie?title={{ucwords(strtolower($movie->title))}}">
                            {{ucwords(strtolower($movie->title))}}
                        </a>
                    </td>
                    <td>
                        <ul class="overviewList">
                            <?php 
                                $actors = explode(',', $movie->actors);
                                for($i = 0; $i < 3; $i++){
                                    echo '<li><a href="/actor?name='.$actors[$i].'">'.ucwords(strtolower($actors[$i])).'</a></li>';
                                }
                            ?>
                        </ul>
                    </td>
                    <td>{{$movie->name}}</td> <!-- Category -->
                    <td>{{round($movie->rating,1)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
@endsection