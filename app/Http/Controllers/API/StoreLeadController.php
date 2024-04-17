<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\LeadsRequest;


class StoreLeadController extends BaseController
{
    public function __invoke(LeadsRequest $request)
    {
        $data = $request->validated();

        $this->replaceNullWithZero($data);

        $token = getenv('AMOCRM_ACCESS_TOKEN');
        
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

        $jsoneLead = json_encode($lead);

        $endpoint = "/api/v4/leads";

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, "https://$this->subDomain.amocrm.ru" . $endpoint);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsoneLead);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_COOKIEFILE, 'amo/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, 'amo/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $status = (int) $status;

        
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
