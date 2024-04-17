<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class ShowLeadController extends BaseController
{
    
    public function __invoke($id) 
    {
        $token = getenv('AMOCRM_ACCESS_TOKEN');
        
        $lead = $this->getLead($token, $id);
        
        return view('amoAPI.show', compact('lead'));
    }

    private function getLead ($token, $id) : array
    {

        $endpoint = "/api/v4/leads/{$id}";

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, "https://$this->subDomain.amocrm.ru" . $endpoint);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_COOKIEFILE, 'amo/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, 'amo/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $status = (int) $status;

       return json_decode($out, true);
    }
}
