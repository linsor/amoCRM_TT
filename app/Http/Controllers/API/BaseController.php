<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Token;
use GuzzleHttp\Psr7\Message;

class BaseController extends Controller
{
    protected $subDomain;
    protected $redirectUri;
    protected $token;
    protected $headers;
   

    protected function amoCRMRequest($body = null, $endpoint = "/api/v4/leads", $method = "GET")
    {

        $curl = curl_init();    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, "https://$this->subDomain.amocrm.ru" . $endpoint);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        if ($method === "POST" || $method === "PATCH"){
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_COOKIEFILE, 'amo/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, 'amo/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $status = (int) $status;

        $response = json_decode($out, true);

        return [$response, $status];

    } 

    public function __construct()
    {
        $this->subDomain = getenv('SUB_DOMAIN');
        $this->redirectUri = getenv('REDIRECT_URL');
        $this->token = getenv('AMOCRM_ACCESS_TOKEN');
        $this->headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->token,
        ];
    }

    public function getLeadFrom($response) 
    {
        foreach ($response as $item){
            if (isset($item['_embedded'])){
                return $item['_embedded'];
            }
            else {
                abort(404, "Сделка не найдена");
            }
        }
    }

    public function replaceNullWithZero ($data) : array 
    {
        foreach ($data as &$item) {
            if ($item === null){
                $item = '0';
            }
        }
        return $data;
    }


}


