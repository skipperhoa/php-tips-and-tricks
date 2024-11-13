<?php 
namespace App\Services;
use App\Config\Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;
class UserService{
   private string $BaseUrl = 'https://dummyjson.com/';
   public function __construct(private HttpClientInterface $client) {}
   public function getUser(string $token): Array
    {
        $response = $this->client->request('GET', $this->BaseUrl.'auth/me', [
            'headers' => [
                'Authorization: Bearer '.$token,
            ]
        ]);
        if (200 !== $response->getStatusCode()) {
            throw new Exception('Response status code is different than expected.');
        }
        $responseJson = $response->getContent();
        $responseData = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);
        return $responseData;
   }
   public function refreshToken(string $refreshToken): Array{
        $response = $this->client->request('POST', $this->BaseUrl.'auth/refresh', [
            'headers' => [
                'Content-Type: application/json',
            ],
            'body' => json_encode([
                'refreshToken' => $refreshToken,
                'expiresInMins' => 30 // optional (FOR ACCESS TOKEN), defaults to 60
            ], JSON_THROW_ON_ERROR),
        ]);
        if (200 !== $response->getStatusCode()) {
           
           throw new Exception('Response status code is different than expected.');
        }
        $responseJson = $response->getContent();
        $responseData = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);
        return $responseData;
   }
   public function login(array $requestData): array
    {
        $requestJson = json_encode($requestData, JSON_THROW_ON_ERROR);
        $response = $this->client->request('POST', $this->BaseUrl.'auth/login', [
            'headers' => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            'body' => $requestJson,
        ]);
        if (200 !== $response->getStatusCode()) {
          //throw new Exception('Response status code is different than expected.');
           $error = [
              'message'=>$response->getContent(false),
              'url'=>$response->getInfo('url'),
              'status'=>$response->getStatusCode(),
              'debug'=>$response->getInfo('debug'),
             // 'info'=>json_encode($response->getInfo()),
           ];
           return json_decode(json_encode($error), true, 512, JSON_THROW_ON_ERROR);
        }
        $responseJson = $response->getContent();
        $responseData = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);
        return $responseData; 
    }
}