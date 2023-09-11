<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

class GamerController extends Controller
{

    public function index()
    {
        return response()->json([
            [
                'data' => auth()->id()
            ]
        ]);
    }
    //score
    public function getScore()
    {

    }

    public function setScore()
    {

    }

    //level
    public function getLevel()
    {

    }

    public function setLevel()
    {

    }
}
