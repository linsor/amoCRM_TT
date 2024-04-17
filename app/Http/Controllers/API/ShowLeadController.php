<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class ShowLeadController extends BaseController
{
    
    public function __invoke($id) 
    {
        $endpoint = "/api/v4/leads/{$id}";
        
        $response = $this->amoCRMRequest(null, $endpoint);
        $lead = $response[0];
        
        return view('amoAPI.show', compact('lead'));
    }
}
