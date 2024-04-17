<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;

class IndexLeadsController extends BaseController
{
    public function __invoke()
    {
        $leads = [];
        $endpoint = '/api/v4/leads';

        $response = $this->amoCRMRequest($endpoint);
        
        foreach ($response as $item){
            if (isset($item['_embedded'])){
                $leads = $item['_embedded'];
                break;
            }
        }
        
        return view('amoAPI.index', compact('leads'));
    }
}
