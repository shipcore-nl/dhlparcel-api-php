<?php
namespace ShipCore\DHLParcel;

use ShipCore\DHLParcel\Http\Client as HttpClient;
use ShipCore\DHLParcel\Http\Response;
use ShipCore\DHLParcel\Exception\ApiException;
use ShipCore\DHLParcel\Entity\Authenticate\Request\ApiKeyCredentials;
use ShipCore\DHLParcel\Entity\Authenticate\Request\RefreshTokenCredentials;
use ShipCore\DHLParcel\Entity\Labels\Request\LabelSpecification;
use ShipCore\DHLParcel\Entity\Labels\Response\Label;
use ShipCore\DHLParcel\Entity\Authenticate\Response\Token;

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
    
    protected function getDefaultHeaders($sendToken = true)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        
        if ($sendToken) {
            $this->authenticate();
            $headers['Authorization'] = 'Bearer ' . trim($this->token->getAccessToken());
        }
        return $headers;
    }
    
    /**
     *
     * @param Response $response
     * @throws ApiException
     */
    private function validateResponse(Response $response)
    {
        $responseCode = intval($response->getResponseCode());
        
        if ($responseCode >= 300) {
            throw new ApiException("", $response);
        }
    }
    
    /**
     *
     * @param Response $response
     * @return mixed
     */
    protected function getResponseData(Response $response)
    {
        $this->validateResponse($response);
        return json_decode($response->getResponseBody(), true);
    }
        
    protected function authenticate()
    {
        if ($this->token) {
            if ($this->isTokenValid($this->token->getAccessTokenExpiration())) {
                return;
            } elseif ($this->isTokenValid($this->token->getRefreshTokenExpiration())) {
                $refreshTokenCredentials = new RefreshTokenCredentials([
                   'refreshToken' => $this->token->getRefreshToken()
                ]);
                
                $response = $this->httpClient->post(
                    $this->getUrl('authenticate/refresh-token'),
                    $this->getDefaultHeaders(false),
                    $refreshTokenCredentials->toDataArray()
                );
                        
                $this->token = Token::fromDataArray($this->getResponseData($response));
                $this->isTokenChanged = true;
                
                return;
            }
        }
        
        $apiKeyCredentials = new ApiKeyCredentials([
            'userId' => $this->userId,
            'key' => $this->key
        ]);
          
        $response = $this->httpClient->post(
            $this->getUrl('authenticate/api-key'),
            $this->getDefaultHeaders(false),
            $apiKeyCredentials->toDataArray()
            );

        $this->token = Token::fromDataArray($this->getResponseData($response));
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
    
    /**
     * @param array $query
     * @return Label[]
     */
    public function getLabels($query)
    {
        throw new \Exception('Not implemented');
    }
    
    /**
     * @param LabelSpecification $labelSpecification
     * @return Label
     */
    public function createLabel(LabelSpecification $labelSpecification)
    {
        $response = $this->httpClient->post(
            $this->getUrl('labels'),
            $this->getDefaultHeaders(),
            $labelSpecification->toDataArray()
            );
                
        return Label::fromDataArray($this->getResponseData($response));
    }

    /**
     * @param string $id
     * @return Label
     */
    public function getLabel($id)
    {
        $response = $this->httpClient->get(
            $this->getUrl("labels/$id"),
            $this->getDefaultHeaders()
            );
        
        return Label::fromDataArray($this->getResponseData($response));
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
