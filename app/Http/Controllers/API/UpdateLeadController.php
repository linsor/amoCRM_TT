<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LeadsRequest;
use App\Http\Requests\UpdateLeadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UpdateLeadController extends BaseController
{
    public function __invoke(UpdateLeadRequest $request, $id)
    {

    $data = $request->validated();

    $this->replaceNullWithZero($data);

    $method = "PATCH";

    $token = getenv('AMOCRM_ACCESS_TOKEN');
    
    $lead = [
        [
            'name' => $data['name'],
            'price' => (int) $data['price'],
            'custom_fields_values' => [
                [
                    'field_id' => 494331,
                    'values' => [
                        [
                        'value' => (int) $data['costPrice']
                        ]
                    ],
                ],
                [
                    'field_id' => 494333,
                    'values' => [
                        [
                        'value' => (int) ($data['price'] - $data['costPrice'])
                        ]
                    ]
                ]
            ]

        ]
    ];

    $body = json_encode($lead);

    $endpoint = "/api/v4/leads/{$id}";

    $response = $this->amoCRMRequest($endpoint, $method, $body);


    dd($response);
    
    return redirect()->route('lead.index');
}

private function replaceNullWithZero ($data) : array 
{
    foreach ($data as &$item) {
        if ($item === null){
            $item = '0';
        }
    }
    return $data;
}
}

