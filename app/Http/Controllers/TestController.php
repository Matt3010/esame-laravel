<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRequest;
use App\Models\Test;

class TestController extends Controller
{

    public function getAllTests(TestRequest $request)
    {
        return response()->json(Test::all()
        );
    }

}
