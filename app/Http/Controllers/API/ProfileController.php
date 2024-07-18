<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'age' => 'required|integer',
            'biodata' => 'required',
            'address' => 'required',
        ]);

        $profile = Profile::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'age' => $request->input('age'),
                'biodata' => $request->input('biodata'),
                'address' => $request->input('address'),
            ]
        );

        return response()->json([
            'message' => 'Profile berhasil update/create',
            'data' => $profile
        ]);
    }
}
