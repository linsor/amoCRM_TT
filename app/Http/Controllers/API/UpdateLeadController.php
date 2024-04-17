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
        $data = $this->replaceNullWithZero($data);

        $endpoint = "/api/v4/leads/{$id}";
        $method = "PATCH";
    
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
        $response = $this->amoCRMRequest($body, $endpoint, $method);

        return redirect()->route('lead.index');
    }

}

