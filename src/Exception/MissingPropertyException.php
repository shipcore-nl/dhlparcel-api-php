<?php

namespace ShipCore\DHLParcel\Exception;

class MissingPropertyException extends \Exception
{
    
    /**
     *
     * @var string
     */
    private $className;
    
    /**
     *
     * @var string
     */
    private $propertyName;
    
    public function __construct($className, $propertyName, \Throwable $previous = null)
    {
        $this->className = $className;
        $this->propertyName = $propertyName;
        $message = "$className::$$propertyName is required.";
        parent::__construct($message, 0, $previous);
    }
}
