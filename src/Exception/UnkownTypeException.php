<?php
namespace ShipCore\DHLParcel\Exception;

class UnkownTypeException extends \Exception
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
        $message = "$className::$$propertyName type could not be resolved.";
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
}
