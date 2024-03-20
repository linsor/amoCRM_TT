<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Models\AccountModel;
use AmoCRM\Exceptions\AmoCRMApiException;
use Exception;


class BaseController extends Controller
{
    protected $subDomain = "kfamilion";
    protected $secretKey = "AVYH0SOZkNUqaFY0cCGUg1HOpU15R64GO9eXqF0FaLfg7jXOKGBjLeOirf41dqGF";
    protected $clientID = "e1dd72ef-b29f-49e9-939a-b2d802fe9b64";
    protected $code = "def50200972ac6590001069a52f34180e08db19066d4d6c6083c5cef98e420bcf9b764bc0deca3bf9c4fafe5a1fb2b513a1cc5b746c5d4d061e59d9e41888290525c7b8e3a9bd0cb46603ab3127e6c1d09aefa28fa4e60fe7ac5d2cc42eba3391cbbed477ddd3d143a692198270b4b44e9b21b065ae2dcebcd6dc0a20fbea982698907e0515e13abf456f7d6316e28f37ddd10370adb684952baa3ea24f779bdb4f1d996907035295747cffa97cf94d6fc5649fb6565d7671531d9430711426b93e6f0d058a2e9b7458762e9643fa483d3ffa3e34a7bc75a1870c48cf13b9adc18ef717bc16b7e008d4959d0f37aa14bba24bf2578a2c685832b2c58b128ab0aacb3930a960ec4ef4404c6bf1457b186d42a4f17c031eedb562828b64adf2946c709486581a070032fd9beee1a0b6dae75a8fbbabdf5f6df6a2b3d7cef02f5553e78c593462efab651c3d3057817fdcb3d9471f48b8b4598698eb591a3875d631647b6a36eb3a2662638aef94e31addcab26e82f9cffd6f8a1d67f049207d69cee92f0b1003ce952608d93cf99b956a8bcf8d20c76d2e6cfb3f71bafe0b9988a6250617aec74f3e72f136e3748ed386e4931be889a817f5484d6b369ca1f9e399058470a8b693ad7839bbbcbbedbcdde385c4212b991b21f00b1eafe51a01e6bd62e7da08a1e";
    protected $redirectUri  = 'http://localhost:8000/test';

    public function testConnect () 
    {
        $apiClient = new AmoCRMApiClient($this->clientID, $this->secretKey, $this->redirectUri);

        $accessToken = $this->getToken($apiClient);

        dd("А ТУТ НАХУЙ?");

        $apiClient->setAccessToken($accessToken)
    ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
    ->onAccessTokenRefresh(
        function (AccessTokenInterface $accessToken, string $baseDomain) {
            saveToken(
                [
                    'accessToken' => $accessToken->getToken(),
                    'refreshToken' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'baseDomain' => $baseDomain,
                ]
            );
        }
    );


//Получим свойства аккаунта со всеми доступными свойствами
try {
    $account = $apiClient->account()->getCurrent(AccountModel::getAvailableWith());
    var_dump($account->toArray());
} catch (AmoCRMApiException $e) {
    printError($e);
}

    }

    private function getToken($apiClient) {


    if (isset($_GET['referer'])) 
    {
        $apiClient->setAccountBaseDomain($_GET['referer']);
    }
    
    
    if (!isset($_GET['code'])) {
        $state = bin2hex(random_bytes(16));
        $_SESSION['oauth2state'] = $state;
        if (isset($_GET['button'])) {
            echo $apiClient->getOAuthClient()->getOAuthButton(
                [
                    'title' => 'Установить интеграцию',
                    'compact' => true,
                    'class_name' => 'className',
                    'color' => 'default',
                    'error_callback' => 'handleOauthError',
                    'state' => $state,
                ]
            );
            die;
        } else {
            $authorizationUrl = $apiClient->getOAuthClient()->getAuthorizeUrl([
                'state' => $state,
                'mode' => 'post_message',
            ]);
            header('Location: ' . $authorizationUrl);
            die;
        }
    } elseif (!isset($_GET['from_widget']) && (empty($_GET['state']) || empty($_SESSION['oauth2state']) || ($_GET['state'] !== $_SESSION['oauth2state']))) {
        unset($_SESSION['oauth2state']);
        exit('Invalid state');
    }
    
    /**
     * Ловим обратный код
     */
    try {
        $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($_GET['code']);

        if (!$accessToken->hasExpired()) {
            saveToken([
                'accessToken' => $accessToken->getToken(),
                'refreshToken' => $accessToken->getRefreshToken(),
                'expires' => $accessToken->getExpires(),
                'baseDomain' => $apiClient->getAccountBaseDomain(),
            ]);
        }
    } catch (Exception $e) {
        die((string)$e);
    }

    }  
  
}
