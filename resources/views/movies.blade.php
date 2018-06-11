@extends('layouts.app')

@section('content')
    <h1>Movies</h1>
    <p>Here are all the movies.</p>
        <table id="moviesPageOverviewTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Actors</th>
                    <th>Category</th>
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
                </tr>
                @endforeach
            </tbody>
        </table>
        <button onClick="loadMore()" id="loadMore" class="text-center">Load more results</button>
@endsection


<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script>
    function loadMore(){
        var url = $(this).attr('href');
        var numberOfRows = document.getElementById("moviesPageOverviewTable").rows.length - 1;

        $.ajax({
            url: url,
            data: {
                "ajax": true,
                "limit" : 10,
                "offset" : numberOfRows
            },
            dataType: 'json',
            type: "GET",
            success: function(data){
                var table = document.getElementById('moviesPageOverviewTable');
                var movie = data[0];
                data.forEach(function(movie){
                    var row = table.insertRow();
                    if(typeof(movie) !== "undefined") {
                        console.log(movie);

                        var titleCell = row.insertCell(0);
                        var actorsCell = row.insertCell(1);
                        var categoryCell = row.insertCell(2);


                        var title = movie.title.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                return letter.toUpperCase();
                        });
                        var titleHtml = '<a href="/movie?title=' + title +'">' + title + '</a>';
                        titleCell.innerHTML = titleHtml;
                        categoryCell.innerHTML = movie.name;
                        var actors = movie.actors.split(',');

                        var actorListHtml = '<ul class="overviewList">';

                        for(var i = 0; i < 3; i++){
                            if(typeof(actors[i]) === 'undefined')
                                break;
                            var actor = actors[i].toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                return letter.toUpperCase();
                            });
                            actorListHtml += '<li><a href="/actor?name=' + actor + '">' + actor + '</a></li>';
                        }
                        actorsCell.innerHTML = actorListHtml + '</ul>';
                    }
                });
            }
        });
    }

</script>