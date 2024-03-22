<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;



class BaseController extends Controller
{
    protected $subDomain = "kfamilion";
    protected $secretKey = "AVYH0SOZkNUqaFY0cCGUg1HOpU15R64GO9eXqF0FaLfg7jXOKGBjLeOirf41dqGF";
    protected $clientID = "e1dd72ef-b29f-49e9-939a-b2d802fe9b64";
    protected $code = "def50200589b74dc9a7e6d7cba73fb220ed53cafa56b4f2ca143fd0bec5e62dfc7f7af9c1d8c971024e57ccf665bc438edab4eb685e1297037a437f7511c567569172b4018b0d6cd057c63918f5f6c25d1bfe513dd1e475682b440e53a03f0e33f944075ea680050f939936eef232a091d1f8bf5d4c0706886ccb7abc51808be7cf89c69aa82e56c049bdb5babdb72dea659960e6d31cb770361c962d46bdf55d1b39c013bf0ac03f6a21660cbe093d2bc82c60bbab150ce434830461f05f016fd27a77bfb5b924e83f25705afd0ca4b34106466c9e60197188c24acfaa8d99137a99a03ef2c31c0e69f87e04f67828ed394b6c47da353945af8576f2ffa5ed9605084b38fb0385b539f97e3469117ef50dc19bb503b02edd82573c6d96f0f92531178b08ae27f7340d7821fc4b372c127dc5de332ef94875374e8056cbcbb6742d5eae81c5ea72c19c6be8f06ad1fcb98248fbe069426042d995ff1466fb92b2ea91307668fd587760145d407ff2df3b14064a5fcd2d43a0e722a650287b793be26bb3184a959e1c77205db97c37408bf44b4af6b5e9f429e31a186b60a2c514f0cb36f2850906cd8b0dd119023e1293057bf8418dc2bbedeb4f1303130ccce436efece8f0c7e629bcf3e18706e5ea3691462d8486858705c718dbcf3dffdb1e357b9dde06a";
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
    $this->accessToken = $Response['access_token'];

    }

}
