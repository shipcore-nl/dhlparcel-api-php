<?php
namespace ShipCore\DHLParcel\Http;

class Response
{
    /**
     *
     * @var string
     */
    protected $method;

    /**
     *
     * @var string
     */
    protected $url;
    /**
     *
     * @var string[]
     */
    protected $requestHeaders;
    
    /**
     *
     * @var string
     */
    protected $requestBody;
    
    /**
     *
     * @var string
     */
    protected $responseCode;
    
    /**
     *
     * @var string[]
     */
    protected $responseHeaders;
    
    /**
     *
     * @var string
     */
    protected $responseBody;
    
    public function __construct(
        $method,
        $url,
        $requestHeaders,
        $requestBody,
        $responseHeaders,
        $responseBody,
        $responseCode
    ) {
        $this->method = $method;
        $this->url = $url;
        $this->requestHeaders = $requestHeaders;
        $this->requestBody = $requestBody;
        $this->responseHeaders = $responseHeaders;
        $this->responseBody = $responseBody;
        $this->responseCode = $responseCode;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function getRequestHeaders()
    {
        return $this->requestHeaders;
    }

    public function getRequestBody()
    {
        return $this->requestBody;
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
}
