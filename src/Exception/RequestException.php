<?php
namespace ShipCore\DHLParcel\Exception;

use ShipCore\DHLParcel\Http\Response;

class RequestException extends \Exception
{
    
    /**
     * @var Response
     */
    private $response;
    
    public function __construct($message, Response $response, \Throwable $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, 0, $previous);
    }
    
    public function getResponse()
    {
        return $this->response;
    }
}
