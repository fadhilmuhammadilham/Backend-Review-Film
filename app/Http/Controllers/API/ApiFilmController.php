<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilmRequest;
use Illuminate\Http\Request;

class ApiFilmController extends Controller
{
    public function store(FilmRequest $request){
        return response()->json([
            "message" => "Api berhasil"
        ],200);
    }
}
