<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'critic' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'movie_id' => 'required|exists:movies,id'
        ]);

        $review = Review::updateOrCreate(
            [
                'user_id' => $user->id,
                'movie_id' => $request->input('movie_id')
            ],
            [
                'critic' => $request->input('critic'),
                'rating' => $request->input('rating')
            ]
        );

        return response()->json([
            'message' => 'Review berhasil update/create',
            'data' => $review
        ]);
    }
}
