<?php
namespace ShipCore\DHLParcel\Http;

class Client
{
    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';
    
    public function request($method, $url, $headers = [], $body = null)
    {
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
