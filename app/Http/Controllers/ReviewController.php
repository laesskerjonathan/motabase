<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function submitReview(Request $request){

        Log::info('Submitting Review');

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
