<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;

class IndexLeadsController extends BaseController
{
    public function __invoke()
    {

        $response = $this->amoCRMRequest();
        $leads = $this->getLeadFrom($response);
        
        return view('amoAPI.index', compact('leads'));
    }
}
