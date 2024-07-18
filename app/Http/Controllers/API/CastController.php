<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CastRequest;
use App\Models\Cast;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CastController extends Controller
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
        $cast = Cast::all();

        return response()->json([
            'messsage' => 'Berhasil Tampil semua cast',
            'data' => $cast
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CastRequest $request)
    {
        $cast = Cast::create($request->all());

        return response()->json([
            'message' => 'Tambah Cast berhasil',
            'body' => $cast
        ],200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $cast = Cast::with('listMovies')->find($id);

        if (!$cast) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        return response()->json([
            'message' => 'Detail Data Cast',
            'data' => $cast
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CastRequest $request, string $id)
    {
        $cast = Cast::find($id);

        if (!$cast) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        $cast->name = $request['name'];
        $cast->age = $request['age'];
        $cast->bio = $request['bio'];

        $cast->save();

        $updatedCast = Cast::find($id);

        return response()->json([
            'message' => 'Update Cast berhasil',
            'data' => $updatedCast
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cast = Cast::find($id);

        if (!$cast) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        $cast->delete();

        return response()->json([
            'message' => 'berhasil Menghapus Cast'
        ]);
    }
}
