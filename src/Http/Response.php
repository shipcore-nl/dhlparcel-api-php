<?php
namespace ShipCore\DHLParcel\Http;

class Response
{
    /**
     *
     * @var string
     */
    protected $responseCode;
    
    /**
     *
     * @var string
     */
    protected $responseHeaders;
    
    /**
     *
     * @var string
     */
    protected $responseBody;
    
    /**
     *
     * @var string
     */
    protected $requestHeaders;
    
    /**
     *
     * @var string
     */
    protected $requestBody;
    
    public function __construct(
        $requestHeaders,
        $requestBody,
        $responseHeaders,
        $responseBody,
        $responseCode
    ) {
        $this->requestHeaders = $requestHeaders;
        $this->requestBody = $requestBody;
        $this->responseHeaders = $responseHeaders;
        $this->responseBody = $responseBody;
        $this->responseCode = $responseCode;
    }
    
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    public function getRequestHeaders()
    {
        return $this->requestHeaders;
    }

    public function getRequestBody()
    {
        return $this->requestBody;
    }
}
