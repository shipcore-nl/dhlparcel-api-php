<?php
namespace ShipCore\DHLParcel\Http;

use GuzzleHttp\RequestOptions;

class Client
{
    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';
    
    private $client;
    
    private function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }
    
    public static function instance()
    {
        return  new Client();
    }
    
    public function request($method, $url, $headers = [], $body = null)
    {
        try {
            $response = $this->client->request($method, $url, [
                RequestOptions::HEADERS => $headers,
                RequestOptions::JSON => $body
            ]);
            
            return new Response(
                $headers,
                $body,
                $response->getHeaders(),
                $response->getBody()->getContents(),
                $response->getStatusCode()
            );
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return new Response(
                $e->getRequest()->getHeaders(),
                $e->getRequest()->getBody()->getContents(),
                $e->getResponse()->getHeaders(),
                $e->getResponse()->getBody()->getContents(),
                $e->getResponse()->getStatusCode()
            );
        }
    }
    
    public function post($url, $headers = [], $body = null)
    {
        return $this->request(self::HTTP_METHOD_POST, $url, $headers, $body);
    }
    
    public function get($url, $headers = [])
    {
        return $this->request(self::HTTP_METHOD_GET, $url, $headers);
    }
}
