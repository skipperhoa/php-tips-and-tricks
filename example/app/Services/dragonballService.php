<?php 
//https://dragonball-api.com/api-docs
namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DragonballService
{
  
    private string $BaseURL = 'https://dragonball-api.com/api';

    public function __construct(private HttpClientInterface $client) {}

    public function  getAll() : Array{

        $response = $this->client->request(
            'GET',
            $this->BaseURL."/characters"
        );
        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
       
        $content = $response->toArray();

        return $content;
    }
    public function getOne(string|int $id) : Array
    {   
        $response = $this->client->request(
            'GET',
            $this->BaseURL."/characters/{$id}"
        );

        return $response->toArray();
    }
}
