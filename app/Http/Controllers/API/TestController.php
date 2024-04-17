<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Token;
use Illuminate\Http\Request;

class TestController extends BaseController
{
    public function index(Request $request) 
    {
        $token = Token::find(1);

        return view("amoAPI.index", compact("token"));
    }
    
}