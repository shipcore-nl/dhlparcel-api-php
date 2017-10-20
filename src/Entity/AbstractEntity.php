<?php
namespace ShipCore\DHLParcel\Entity;

use ShipCore\DhlParce\Annotation\Accessible;
use Doctrine\Common\Annotations\AnnotationReader;
use PhpDocReader\PhpDocReader;

abstract class AbstractEntity implements \JsonSerializable
{
    /**
     *
     * @var AnnotationReader
     */
    private static $annotationReader;
    
    /**
     *
     * @var PhpDocReader
     */
    private static $docReader;
    
    public function __construct($data)
    {
        $className = static::class;
        $reflectionClass = new \ReflectionClass($className);
        
        /* @var $property \ReflectionProperty */
        foreach ($reflectionClass->getProperties() as $property) {
            if (isset($data[$property->getName()]) && $this->canAccess($property)) {
                $this->setData($property->getName(), $data[$property->getName()]);
            } elseif ($this->isRequired($property)) {
                throw new \ShipCore\DHLParcel\Exception\MissingPropertyException(
                    $className,
                    $property->getName()
                );
            }
        }
    }
    
    private function isRequired(\ReflectionProperty $property)
    {
        $accessibleAnnotation = self::getAnnotationReader()->getPropertyAnnotation($property, \ShipCore\DHLParcel\Annotation\Required::class);
        return $accessibleAnnotation;
    }
    
    private function canAccess(\ReflectionProperty $property)
    {
        $accessibleAnnotation = self::getAnnotationReader()->getPropertyAnnotation($property, \ShipCore\DHLParcel\Annotation\Accessible::class);
        return $accessibleAnnotation;
    }
    
    private function getType(\ReflectionProperty $property)
    {
        $docReader = self::getDocReader();
        
        if ($docReader->getPropertyClass($property)) {
            return $docReader->getPropertyClass($property);
        }
        
        $matches = [];
        if (preg_match('/@var\s+([^\s]+)/', $property->getDocComment(), $matches)) {
            list(, $primitiveType) = $matches;
            return $primitiveType;
        } else {
            throw new \ShipCore\DHLParcel\Exception\UnkownTypeException(
                get_class($this),
                $property->getName()
            );
        }
    }
    
    private function checkType($type, $value)
    {
        switch ($type) {
            case "boolean":
                return is_bool($value);
            case "integer":
                return is_int($value);
            case "string":
                return is_string($value);
            case "double":
                return is_float($value);
            case "mixed":
                return true;
            default:
                return $value instanceof $type;
        }
    }
    
    private function setData($propertyName, $value)
    {
        $className = static::class;
        $reflectionClass = new \ReflectionClass($className);
        $property = $reflectionClass->getProperty($propertyName);
        if ($property && $this->canAccess($property)) {
            $propertyClass = self::getDocReader()->getPropertyClass($property);
            if ($propertyClass && is_array($value)) {
                $value = new $propertyClass($value);
            }
            
            if ($this->checkType($this->getType($property), $value)) {
                $property->setAccessible(true);
                $property->setValue($this, $value);
            } else {
                throw new \ShipCore\DHLParcel\Exception\InvalidTypeException(
                    get_class($this),
                    $property->getName(),
                    $this->getType($property)
                );
            }
        }
    }
    
    /**
     *
     * @param string $propertyName
     * @return bool
     */
    private function propertyExists($propertyName)
    {
        $className = static::class;
        $reflectionClass = new \ReflectionClass($className);
        return $reflectionClass->hasProperty($propertyName);
    }
    
    private function getProperty($propertyName)
    {
        $className = static::class;
        $reflectionClass = new \ReflectionClass($className);
        $property = $reflectionClass->getProperty($propertyName);
        if ($property && $this->canAccess($property)) {
            $property->setAccessible(true);
            return $property->getValue($this);
        }
    }
    
    private function setProperty($propertyName, $value)
    {
        $className = static::class;
        $reflectionClass = new \ReflectionClass($className);
        $property = $reflectionClass->getProperty($propertyName);
        if ($property && $this->canAccess($property)) {
            if ($this->checkType($this->getType($property), $value)) {
                $property->setAccessible(true);
                $property->setValue($this, $value);
            } else {
                throw new \ShipCore\DHLParcel\Exception\InvalidTypeException(
                    get_class($this),
                    $property->getName(),
                    $this->getType($property)
                );
            }
        }
    }
    
    /**
     * Set/Get attribute wrapper
     *
     * @param   string $method
     * @param   array $args
     * @return  mixed
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        switch (substr($method, 0, 3)) {
            case 'get':
                $propertyName = lcfirst(substr($method, 3));
                if (!$this->propertyExists($propertyName)) {
                    throw new \ShipCore\DHLParcel\Exception\InvalidPropertyException(
                       get_class($this),
                       $propertyName
                    );
                }
                return $this->getProperty($propertyName);
            case 'set':
                $propertyName = lcfirst(substr($method, 3));
                if (!$this->propertyExists($propertyName)) {
                    throw new \ShipCore\DHLParcel\Exception\InvalidPropertyException(
                       get_class($this),
                       $propertyName
                    );
                }
                $value = isset($args[0]) ? $args[0] : null;
                return $this->setProperty($propertyName, $value);
        }
        throw new \Exception('Invalid method ' .get_class($this) . "::" . $method);
    }
    
    /**
     *
     * @return AnnotationReader
     */
    private static function getAnnotationReader()
    {
        if (!self::$annotationReader) {
            self::$annotationReader =  new AnnotationReader();
        }
        return self::$annotationReader;
    }
    
    /**
     *
     * @return PhpDocReader
     */
    private static function getDocReader()
    {
        if (!self::$docReader) {
            self::$docReader =  new PhpDocReader();
        }
        return self::$docReader;
    }
    
    public function jsonSerialize()
    {
        $className = static::class;
        $reflectionClass = new \ReflectionClass($className);
        $annotationReader = self::getAnnotationReader();
        
        $data = [];
        /* @var $property \ReflectionProperty */
        foreach ($reflectionClass->getProperties() as $property) {
            $accessibleAnnotation = $annotationReader->getPropertyAnnotation($property, '\ShipCore\DHLParcel\Annotation\Accessible');
            if ($accessibleAnnotation) {
                $property->setAccessible(true);
                $data[$property->getName()] = $property->getValue($this);
            }
        }
        
        return $data;
    }
    
    public static function jsonDeserialize($data)
    {
        $className = static::class;
        return new $className($data);
    }
}
