<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\LeadsRequest;


class StoreLeadController extends BaseController
{
    public function __invoke(LeadsRequest $request)
    {
        $data = $request->validated();
        $method = "POST";
        $endpoint = "/api/v4/leads";

        $data = $this->replaceNullWithZero($data);
        
        $lead = [
            [
                'name' => $data['name'],
                'price' => (float)$data['price'],
                'custom_fields_values' => [
                    [
                        'field_id' => 494331,
                        'values' => [
                            [
                            'value' => $data['costPrice']
                            ]
                        ],
                    ],
                    [
                        'field_id' => 494333,
                        'values' => [
                            [
                            'value' => ($data['price'] - $data['costPrice'])
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
