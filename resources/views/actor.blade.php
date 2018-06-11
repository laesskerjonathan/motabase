<?php 
  $actor = $response['actor'];
  $reviews = $response['reviews'];
?>


@extends('layouts.app')

@section('content')
<div class="card mb-3">
  <div class="card-body">
    <div id="without-review">
        <h1 class="card-title">{{ucwords(strtolower($actor[0]->first_name." ".$actor[0]->last_name))}}</h1>
        <h3>Movies</h3>
        <table id="moviesPageOverviewTable" class="table table-bordered overviewList">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php 
                    $movies = explode(',', $actor[0]->movies); 
                ?> 
                @foreach($movies as $movie)
                <?php 
                    $exploded_movie = explode(';', $movie);
                ?> 
                <!-- category title rating year -->
                <tr>
                    <td>
                        <a href="/movie?title={{$exploded_movie[1]}}">
                            {{ucwords(strtolower($exploded_movie[1]))}}
                        </a>
                    </td>
                    <td>{{$exploded_movie[0]}}</td>
                    <td>{{round($exploded_movie[2],1)}}</td> 
                </tr>
                @endforeach
                
            </tbody>
        </table>
        </ul>      <h3>Reviews</h3>
        @if(count($reviews) > 0)
            @foreach($reviews as $review)
            <div class="card mb-3 text-white bg-secondary">
            <div class="card-body">
                <div class="card-header"><h3>Written by {{$review->user}} at {{$review->created_at}}</h3></div>
                <div class="card-body">
                <p>{{$review->review}}</p>
                </div>
            </div>
            </div>
            @endforeach
        @else
        <p>There are no Reviews. Be the first to write an awsome Review.</p>
        @endif
    </div>
  </div>
  @include('inc.messages')
  <div id="error-messages"></div>
  @guest
    <div class="p-3 mb-2 bg-danger text-white">
      <p>Log in to leave a review</p>
    </div>
  @else
  <?php 
      $user = Auth::user()->name; 
      $title = $actor[0]->first_name." ".$actor[0]->last_name;
  ?>
      {!! Form::open(['url' => 'movie/submit', 'id' => 'review']) !!}
        <div class="form-group">
          {{Form::label('review', 'Post a Review as User "'.$user.'"')}}
          {{Form::textarea('review', '', ['class' => 'form-control', 'placeholder' => 'Write your Review here...', 'required' => 'true'])}}
          {!! Form::hidden('title', $title) !!}
          {!! Form::hidden('user', $user) !!}
        </div>
        <div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </div>
        {!! Form::close() !!}

  @endguest
</div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  jQuery( document ).ready( function( $ ) {
    $('#review').submit(false);

    $( '#review' ).on( 'submit', function(e) {

        var review = $(this).find('textarea[name=review]').val();
        var title = $(this).find('input[name=title]').val();
        var user = $(this).find('input[name=user]').val();

        console.log("r: " + review);
        console.log("t: " + title);
        console.log("u: " + user);

      $.ajax({
          type: "POST",
          url: '/review/submit',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: { review:review, title:title, user:user }, 
          success: function( data ) {
            console.log(data);
            var newCardHtml = '<div class="card mb-3 text-white bg-secondary"><div class="card-body"><div class="card-header"><h3>Written by '
             + data.user + ' at ' + data.created_at + '</h3></div><div class="card-body"><p>' + data.review + '</p></div></div>';
            $('#without-review').append(newCardHtml);
          },
          error: function(error) {
              console.log(error);
          }
      });

    });
});
</script>