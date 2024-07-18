<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
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
        $movie = Movie::all();

        return response()->json([
            'message' => 'Data berhasil ditampilkan',
            'data' => $movie
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('poster')) {

            $imageName = time().'.'.$request->poster->getClientOriginalExtension();
            
            $request->poster->storeAs('public/images', $imageName);

            $path = env('APP_URL').'/storage/images/';
            
            $validatedData['poster'] = $path.$imageName;
        }

        $movie = Movie::create($validatedData);

        return response()->json([
            'message' => 'Tambah Movie berhasil',
            'body' => $validatedData
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::with('listCasts')->find($id);

        if (!$movie) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        return response()->json([
            'message' => 'Detail Data movie',
            'data' => $movie
        ],200); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovieRequest $request, string $id)
    {
        $data = $request->validated();
    
        $movie = Movie::find($id);
    
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
    
        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::delete('public/images/' . $movie->poster);
            }
    
            $imageName = time().'.'.$request->poster->getClientOriginalExtension();
            $request->poster->storeAs('public/images', $imageName);
            $data['poster'] = $imageName;
        }
    
        $movie->update($data);
    
        return response()->json([
            'message' => 'Movie updated successfully',
            'data' => $movie
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);
    
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
    
        if ($movie->poster) {
            if ($movie->poster) {
                Storage::delete('public/images/' . $movie->poster);
            }
        }

        $movie->delete();

        return response()->json([
            'message' => 'berhasil menghapus movie'
        ],200);
    }
}
