<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class TestController extends BaseController
{
    public function index(Request $request) 
    {
        var_dump($this->accessToken);
    }
    
}
