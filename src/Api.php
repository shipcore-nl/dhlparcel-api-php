<?php
namespace ShipCore\DHLParcel;

use ShipCore\DHLParcel\Http\Client as HttpClient;
use ShipCore\DHLParcel\Http\Response;
use ShipCore\DHLParcel\Exception\ApiException;
use ShipCore\DHLParcel\Entity\Authenticate\Request\ApiKeyCredentials;
use ShipCore\DHLParcel\Entity\Authenticate\Request\RefreshTokenCredentials;
use ShipCore\DHLParcel\Entity\Labels\Request\LabelQuery;
use ShipCore\DHLParcel\Entity\Labels\Request\LabelSpecification;
use ShipCore\DHLParcel\Entity\Labels\Response\Label;
use ShipCore\DHLParcel\Entity\Authenticate\Response\Token;
use ShipCore\DHLParcel\Entity\ParcelTypes\Request\ParcelQuery;
use ShipCore\DHLParcel\Entity\ParcelTypes\Response\ParcelType;
use ShipCore\DHLParcel\Entity\Products\Request\ProductQuery;
use ShipCore\DHLParcel\Entity\Products\Response\Product;
use ShipCore\DHLParcel\Entity\ShipmentOptions\Response\ShipmentOption;
use ShipCore\DHLParcel\Entity\Capabilities\Request\CapabilityQuery;
use ShipCore\DHLParcel\Entity\Capabilities\Response\Capability;
use ShipCore\DHLParcel\Entity\TimeWindows\Request\TimeWindowQuery;
use ShipCore\DHLParcel\Entity\TimeWindows\Response\TimeWindow;

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
        $url = ($this->sandbox ? self::BASE_URL_ACCEPT : self::BASE_URL) . $path;
        
        if (count($query)) {
            $url .= '?' . http_build_query($query);
        }
        
        return $url;
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
     * @param Response $response
     *
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
    
    /**
     * @param string $senderType
     * @param CapabilityQuery $capabilityQuery
     *
     * @return Capability[]
     */
    public function getCapabilities($senderType, CapabilityQuery $capabilityQuery = null)
    {
        $response = $this->httpClient->get(
            $this->getUrl("capabilities/$senderType", $capabilityQuery ? $capabilityQuery->toDataArray() : []),
            $this->getDefaultHeaders()
            );
        
        $capabilities = [];
        
        foreach ($this->getResponseData($response) as $capabilityData) {
            $capabilities[] = Capability::fromDataArray($capabilityData);
        }
        
        return $capabilities;
    }
    
    /**
     * @param string $senderType
     * @param string $fromCountry
     *
     * @return string[]
     */
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
     * @param LabelQuery $labelQuery
     *
     * @return Label[]
     */
    public function getLabels(LabelQuery $labelQuery)
    {
        $response = $this->httpClient->get(
            $this->getUrl("labels"),
            $this->getDefaultHeaders()
            );
        
        $labels = [];
        
        foreach ($this->getResponseData($response) as $labelData) {
            $labels[] = Label::fromDataArray($labelData);
        }
        
        return $labels;
    }
    
    /**
     * @param LabelSpecification $labelSpecification
     *
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
     *
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

    /**
     * @param string $senderType
     * @param string $fromCountry
     * @param ParcelQuery $parcelQuery
     *
     * @return ParcelType[]
     */
    public function getParcelTypes($senderType, $fromCountry, ParcelQuery $parcelQuery = null)
    {
        $response = $this->httpClient->get(
            $this->getUrl("parcel-types/$senderType/$fromCountry", $parcelQuery ? $parcelQuery->toDataArray() : []),
            $this->getDefaultHeaders()
            );
        
        $parcelTypes = [];
        
        foreach ($this->getResponseData($response) as $parcelTypeData) {
            $parcelTypes[] = ParcelType::fromDataArray($parcelTypeData);
        }
        
        return $parcelTypes;
    }
    
    /**
     * @param ProductQuery $productQuery
     *
     * @return Product[]
     */
    public function getProducts(ProductQuery $productQuery = null)
    {
        $response = $this->httpClient->get(
            $this->getUrl("products", $productQuery ? $productQuery->toDataArray() : []),
            $this->getDefaultHeaders()
            );
        
        $products = [];
        print_r($response);
        foreach ($this->getResponseData($response) as $productData) {
            $products[] = Product::fromDataArray($productData);
        }
        
        return $products;
    }
    
    /**
     * @param string $productKey
     *
     * @return Product
     */
    public function getProduct($productKey)
    {
        $response = $this->httpClient->get(
            $this->getUrl("products/$productKey"),
            $this->getDefaultHeaders()
            );
        
        return Product::fromDataArray($this->getResponseData($response));
    }
    
    /**
     * @param string $senderType
     *
     * @return ShipmentOption[]
     */
    public function getShipmentOptions($senderType)
    {
        $response = $this->httpClient->get(
            $this->getUrl("shipment-options/$senderType"),
            $this->getDefaultHeaders()
            );
        
        $shipmentOptions = [];
        
        foreach ($this->getResponseData($response) as $shipmentOptionsData) {
            $shipmentOptions[] = ShipmentOption::fromDataArray($shipmentOptionsData);
        }
        
        return $shipmentOptions;
    }
    
    /**
     * @param TimeWindowQuery $timeWindowQuery
     *
     * @return TimeWindow[]
     */
    public function getTimeWindows(TimeWindowQuery $timeWindowQuery = null)
    {
        $response = $this->httpClient->get(
            $this->getUrl("time-windows", $timeWindowQuery ? $timeWindowQuery->toDataArray() : []),
            $this->getDefaultHeaders()
            );
        
        $timeWindows = [];
        
        foreach ($this->getResponseData($response) as $timeWindowData) {
            $timeWindows[] = TimeWindow::fromDataArray($timeWindowData);
        }
        
        return $timeWindows;
    }
}
