<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;

class CreateLeadsController extends Controller
{
    public function __invoke(Request $request)
    {
       // $token = Token::find(1);

        return view("amoAPI.create");
    }
}


