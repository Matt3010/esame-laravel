<?php

namespace App\Http\Controllers;

use App\Models\Test;

class TestController extends Controller
{

    public function getAllTests()
    {
        return response()->json(Test::all()
        );
    }

}
