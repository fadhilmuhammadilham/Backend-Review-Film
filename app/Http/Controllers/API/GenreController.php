<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
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
        $genre = Genre::all();

        return response()->json([
            'message' => 'tampil data berhasil',
            'data' => $genre
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GenreRequest $request)
    {
        $genre = Genre::create($request->all());

        return response()->json([
            'message' => 'Tambah Genre berhasil',
            'body' => $genre
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::with('listMovie')->find($id);

        if (!$genre) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        return response()->json([
            'message' => 'Detail Data Cast',
            'data' => $genre
        ],200); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GenreRequest $request, string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        $genre->name = $request['name'];

        $genre->save();

        $updategenre = Genre::find($id);

        return response()->json([
            'message' => 'Update Genre berhasil',
            'data' => $updategenre
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        $genre->delete;

        return response()->json([
            'message' => 'berhasil Menghapus Genre'
        ]);
    }
}
