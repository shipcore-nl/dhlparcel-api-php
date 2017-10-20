<?php

namespace ShipCore\DHLParcel\Exception;

class InvalidTypeException extends \Exception
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
    
    /**
     *
     * @var string
     */
    private $type;
    
    public function __construct($className, $propertyName, $type, \Throwable $previous = null)
    {
        $this->className = $className;
        $this->propertyName = $propertyName;
        $this->type = $type;
        $message = "$className::$$propertyName expect's it's value to be of $type.";
        parent::__construct($message, 0, $previous);
    }
    
    public function getClassName()
    {
        return $this->className;
    }

    public function getPropertyName()
    {
        return $this->propertyName;
    }
    
    public function getType()
    {
        return $this->type;
    }
}
