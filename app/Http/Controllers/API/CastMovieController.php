<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CastMovieRequest;
use App\Models\CastMovie;
use Illuminate\Http\Request;

class CastMovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
        $this->middleware('UserAdmin')->only(['store', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $castm = CastMovie::all();

        return response()->json([
            'message' => 'Berhasil Tampil cast Movie',
            'data' => $castm
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CastMovieRequest $request)
    {
        $castm = CastMovie::create($request->all());

        return response()->json([
            'message' => 'Tambah cast movie berhasil',
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $castm = CastMovie::with(['cast', 'movie'])->find($id);

        if (!$castm) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        return response()->json([
            'message' => 'Detail Data Cast movie',
            'data' => $castm
        ],200); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CastMovieRequest $request, string $id)
    {
        $castm = CastMovie::find($id);

        if (!$castm) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        $castm->name = $request['name'];
        $castm->cast_id = $request['cast_id'];
        $castm->movie_id = $request['movie_id'];

        $castm->save();

        return response()->json([
            'message' => 'Berhasil update cast movie',
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $castm = CastMovie::find($id);

        if (!$castm) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        $castm->delete;

        return response()->json([
            'message' => 'Berhasil delete cast movie'
        ]);
    }
}
