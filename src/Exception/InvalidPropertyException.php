<?php

namespace ShipCore\DHLParcel\Exception;

class InvalidPropertyException extends \Exception
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
        $message = "$className does not have an accessible property $$propertyName.";
        parent::__construct($message, 0, $previous);
    }
}
