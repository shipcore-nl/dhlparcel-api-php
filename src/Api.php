<?php
namespace ShipCore\DHLParcel;

use ShipCore\DHLParcel\Http\Client as HttpClient;
use ShipCore\DHLParcel\Entity\Request\AuthRequest;
use ShipCore\DHLParcel\Entity\Request\AuthRefreshRequest;
use ShipCore\DHLParcel\Entity\Request\CreateLabelRequest;
use ShipCore\DHLParcel\Entity\Label;

class Api
{
    const BASE_URL= 'https://api-gw.dhlparcel.nl/';
    const BASE_URL_ACCEPT = 'https://api-gw-accept.dhlparcel.nl/';
    
    protected $userId;
    protected $key;
    protected $token;
    protected $sandbox;

    protected $httpClient;
    
    protected $isTokenChanged = false;
    
    public function __construct(
        $userId,
        $key,
        $token = null,
        $sandbox = false
    ) {
        $this->userId = $userId;
        $this->key = $key;
        $this->token = $token;
        $this->sandbox = $sandbox;
        
        $this->httpClient = HttpClient::instance();
        $this->authenticate();
    }
    
    protected function isTokenValid($expirationTime)
    {
        return $expirationTime - 30 > time();
    }
    
    protected function getUrl($path, $query = [])
    {
        // TODO add query to url
        return ($this->sandbox ? self::BASE_URL_ACCEPT : self::BASE_URL) . $path;
    }
    
    protected function getDefaultHeaders()
    {
        return [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->token->getAccessToken()
        ];
    }
    
    protected function getResponseData($response)
    {
        // TODO validate response
        return json_decode($response[0], true);
    }
        
    protected function authenticate()
    {
        if ($this->token) {
            if ($this->isTokenValid($this->token->getAccessTokenExpiration())) {
                return;
            } elseif ($this->isTokenValid($this->token->getRefreshTokenExpiration())) {
                $refreshRequest = new AuthRefreshRequest([
                   'refreshToken' => $this->token->getRefreshToken()
                ]);
                
                $response = $this->httpClient->post(
                    $this->getUrl('authenticate/refresh-token'),
                    null,
                    $refreshRequest->jsonSerialize()
                    );
        
                $this->token = Token::jsonDeserialize($this->getResponseData($response));
                $this->isTokenChanged = true;
                
                return;
            }
        }
        
        $authRequest = new AuthRequest([
            'userId' => $this->userId,
            'key' => $this->key
        ]);
        
        $response = $this->httpClient->post(
            $this->getUrl('authenticate/api-key'),
            null,
            $authRequest->jsonSerialize()
            );
        
        $this->token = Token::jsonDeserialize($this->getResponseData($response));
        $this->isTokenChanged = true;
    }
    
    public function getNewToken()
    {
        return $this->isTokenChanged ? $this->token : null;
    }
    
    public function getCapabilities($senderType, $query = [])
    {
        throw new \Exception('Not implemented');
    }
    
    public function getDestinationCountries($senderType, $fromCountry)
    {
        $response = $this->httpClient->get(
            $this->getUrl("destination-countries/$senderType/$fromCountry"),
            $this->getDefaultHeaders()
            );
        
        return $this->getResponseData($response);
    }
    
    public function findParcelShopLocations($countryCode, $query = [])
    {
        throw new \Exception('Not implemented');
    }
    
    // returns array of LabelResponse (without pdf)
    public function getLabels($query)
    {
        throw new \Exception('Not implemented');
    }
    
    // returns Label
    public function createLabel(CreateLabelRequest $labelRequest)
    {
        $response = $this->httpClient->post(
            $this->getUrl('labels'),
            $this->getDefaultHeaders(),
            $labelRequest->jsonSerialize()
            );
        
        return Label::jsonDeserialize($this->getResponseData($response));
    }

    // returns Label
    public function getLabel($id)
    {
        $response = $this->httpClient->get(
            $this->getUrl("labels/$id"),
            $this->getDefaultHeaders()
            );
        
        return Label::jsonDeserialize($this->getResponseData($response));
    }
    
    public function getParcelTypes($senderType, $fromCountry, $query = [])
    {
        throw new \Exception('Not implemented');
    }
    
    public function getProducts($query = [])
    {
        throw new \Exception('Not implemented');
    }
    
    public function getProduct($productKey)
    {
        throw new \Exception('Not implemented');
    }
    
    public function getShipmentOptions($senderType)
    {
        throw new \Exception('Not implemented');
    }
    
    public function getTimeWindows($query =[])
    {
        throw new \Exception('Not implemented');
    }
}
