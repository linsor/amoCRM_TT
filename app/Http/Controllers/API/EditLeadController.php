<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class EditLeadController extends BaseController
{
    public function __invoke($id) 
    {
        
        $endpoint = "/api/v4/leads/{$id}";
        $costPrice = 0;

        $response = $this->amoCRMRequest(null, $endpoint);
        $lead = $response[0];

        foreach($lead['custom_fields_values'] as $customField){
            if ($customField['field_name'] === 'Себестоимость'){
                foreach ($customField['values'] as $value){
                    $costPrice = $value['value'];
                }
            }
        }
        
        return view('amoAPI.edit', compact('lead','costPrice'));
    }
}
