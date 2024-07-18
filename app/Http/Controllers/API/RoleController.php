<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();

        return response()->json([
            'message' => 'Data Berhasil di tampilkan',
            'data' => $role
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $movie = Role::create($request->all());

        return response()->json([
            'message' => 'Data berhasil ditambahkan',
            'body' => $movie
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        $role->name = $request['name'];

        $role->save();

        return response()->json([
            'message' => 'Data berhasil diupdate',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ],404);
        }

        $role->delete();

        return response()->json([
            'message' => 'Data Detail berhasil Dihapus',
        ],200);
    }
}
