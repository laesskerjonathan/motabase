<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;

class ReviewController extends Controller
{
    public function submitReview(Request $request){


        $this->validate($request, [
            'review' => 'required',
            'title' => 'required',
            'user' => 'required'
        ]);
        

        //Create Review
        $review = new Review;
        $review->review = $request->input('review');
        $review->title = $request->input('title');
        $review->user = $request->input('user');

        $review->save();

        return $review;
    }
}
