<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;

class CreateLeadsController extends Controller
{
    public function __invoke(Request $request)
    {
        return view("amoAPI.create");
    }
}


