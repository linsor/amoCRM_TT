<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Token;

class BaseController extends Controller
{
    protected $subDomain = "kfamilion";
    protected $secretKey = "AVYH0SOZkNUqaFY0cCGUg1HOpU15R64GO9eXqF0FaLfg7jXOKGBjLeOirf41dqGF";
    protected $clientID = "e1dd72ef-b29f-49e9-939a-b2d802fe9b64";
    protected $code = "def502006a69cbc3021e0686d655e6110b776cd16c776669d47b61528f6f4d9d22a9a91af433c6640c66f48291324b2c4c788daa01843c7c27ead429b1c8415cc8dcb050a92c3318fd83815a535144f4f4757abd9ce7e8f4c8727a32f58bd7f605bfb7acb05e9cf80d7d837992c558a89380e29f7bda43ef3e41b941ff9c4438b64b8432041f1f518f9644a966dea1beb9a02985a5cc2920e67e99e460029359ff475e45b222dfa462563fffd22ed3766bfc8203eaadb7ff358bdac2d0bcffbe977af825aa7eaea6a3cb6fe4f535c1a2199d34eb8663a965e9d0003eccf667455d45eb197056e2e98c0d6f6504bf294bb60743004f44a9b624e8f97c626698639fa4f582c82833b64e3fb1a3acec1445f3cb60a022d7752f93f970c4b890e4c14a1aa85a83cc6d1d66a53acdce26618c2fc394e53afbb5d2489a0088c4fb13afbd6703eb99579e45426821eedc8ff9d88402240838766ed4afa412d61f5796b78f66d49c279da442658bbf0f44150a56a8f794cb3425bebd8284dbaac2bb4a889f9cf5b5790b0c6ca7efb386084f3dc5a92adcd2b2ed892394fd2423d34605e51dd8dacc4a1c08a98487010e57764318e0384c52d60b2c63038579dc8c9a9ac3b8e78cf5c286e5e5c50bc2430024d24bb4e26b98aa791ef4f47ff8943b99ab093203bb62ac7c";
    protected $redirectUri  = 'http://localhost:8000';
    protected $accessToken;

    public function getToken () 
    {
        $link = "https://$this->subDomain.amocrm.ru/oauth2/access_token";

        $data = [
            'client_id'     => $this->clientID,
            'client_secret' => $this->secretKey,
            'grant_type'    => 'authorization_code',
            'code'          => $this->code,
            'redirect_uri'  => $this->redirectUri,
          ];
          $this->postConnect ($link, $data);

          return redirect(route('test'));
        }

    public function postConnect ($link, $data) {

        $token = Token::all();

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;
        $errors = [
            301 => 'Moved permanently.',
            400 => 'Wrong structure of the array of transmitted data, or invalid identifiers of custom fields.',
            401 => 'Not Authorized. There is no account information on the server. You need to make a request to another server on the transmitted IP.',
            403 => 'The account is blocked, for repeatedly exceeding the number of requests per second.',
            404 => 'Not found.',
            500 => 'Internal server error.',
            502 => 'Bad gateway.',
            503 => 'Service unavailable.'
        ];

    if ($code < 200 || $code > 204) die( "Error $code. " . (isset($errors[$code]) ? $errors[$code] : 'Undefined error') );


    
    $Response = json_decode($out, true);
    $token = Token::create($Response);
    

    }

}
