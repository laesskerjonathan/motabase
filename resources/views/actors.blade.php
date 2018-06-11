@extends('layouts.app')

@section('content')
    <h1>Actors</h1>
    <p>Here are all the actors.</p>
        <table id="actorsPageOverviewTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Movies</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actors as $actor)
                <tr>
                    <td><a href="/actor?name={{$actor->name}}">{{ucwords(strtolower($actor->name))}}</a></td>
                    <td>
                        <ul class="overviewList">
                            <?php 
                                $movies = explode(',', $actor->movies);
                                for($i = 0; $i <3; $i++)
                                    echo '<li><a href="/movie?title='.$movies[$i].'">'.ucwords(strtolower($movies[$i])).'</a></li>';
                            ?>
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button onClick="loadMore()" id="loadMore">Load more results</button>
@endsection

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script>
    function loadMore(){
        var url = $(this).attr('href');
        var numberOfRows = document.getElementById("actorsPageOverviewTable").rows.length - 1;

        $.ajax({
            url: url,
            data: {
                "ajax": true,
                "limit" : 5,
                "offset" : numberOfRows
            },
            dataType: 'json',
            type: "GET",
            success: function(data){
                var table = document.getElementById('actorsPageOverviewTable');
                var actor = data[0];
                data.forEach(function(actor){
                    var row = table.insertRow();
                    if(typeof(actor) !== "undefined") {
                        console.log(actor);

                        var nameCell = row.insertCell(0);
                        var moviesCell = row.insertCell(1);

                        var name = actor.name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                return letter.toUpperCase();
                            });
                        var nameHtml = '<a href="/actor?name=' + name + '">' + name + '</a>';
                        nameCell.innerHTML = nameHtml;
                        var movies = actor.movies.split(',');

                        var movieListHtml = '<ul class="overviewList">';

                        
                        for(var i = 0; i < 3; i++){
                            if(typeof(movies[i]) === 'undefined')
                                break;
                            var movie = movies[i].toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                return letter.toUpperCase();
                            });
                            movieListHtml += '<li><a href="/movie?title=' + movie + '">' + movie + '</a></li>';
                        }
                        moviesCell.innerHTML = movieListHtml + '</ul>';
                    }
                });
            }
        });
    }

</script>