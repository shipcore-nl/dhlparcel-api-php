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
    
    /**
     * Returns array type with stripped []
     * @param string $type
     * @return string
     */
    private function getArrayItemsType($type)
    {
        return substr($type, 0, strlen($type) - 2);
    }
    
    /**
     * Returns raw string type format from the var annotation
     * @param \ReflectionProperty $property
     * @return string
     */
    private function getRawType(\ReflectionProperty $property)
    {
        $matches = [];
        if (preg_match('/@var\s+([^\s]+)/', $property->getDocComment(), $matches)) {
            list(, $rawType) = $matches;
        } else {
            throw new \ShipCore\DHLParcel\Exception\UnkownTypeException(
                get_class($this),
                $property->getName()
            );
        }
        return $rawType;
    }
    
    /**
     *
     * @param string $rawType
     * @return bool
     */
    private function isArrayType($rawType)
    {
        return substr($rawType, -2) == "[]";
    }
    
    /**
     *
     * @param \ReflectionProperty $property
     * @return string
     * @throws \ShipCore\DHLParcel\Exception\UnkownTypeException
     */
    private function getType(\ReflectionProperty $property)
    {
        $docReader = self::getDocReader();
        
        if ($docReader->getPropertyClass($property)) {
            return $docReader->getPropertyClass($property);
        }
        
        return $this->getRawType($property);
    }
    
    /**
     *
     * @param \ReflectionProperty $property
     * @param string $type
     * @param mixed $value
     */
    private function parseArrayType(\ReflectionProperty $property, $type, $value)
    {
        if (!is_array($value)) {
            throw new \ShipCore\DHLParcel\Exception\InvalidTypeException(
                    get_class($this),
                    $property->getName(),
                    $this->getType($property)
            );
        }
        $itemType = $this->getArrayItemsType($type);
        $items = [];
        foreach ($value as $item) {
            if (
                (class_exists($itemType) || interface_exists($itemType))
                && is_array($item)
                && is_subclass_of($itemType, \ShipCore\DHLParcel\Entity\AbstractEntity::class)
            ) {
                $item = new $itemType($item);
            }
            if (!$this->checkType($itemType, $item)) {
                throw new \ShipCore\DHLParcel\Exception\InvalidTypeException(
                    get_class($this),
                    $property->getName(),
                    $this->getType($property)
                );
            }
            $items[] = $item;
        }
        return $items;
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
            
            $rawType = $this->getRawType($property);
            if ($this->isArrayType($rawType)) {
                $valueArray = $this->parseArrayType($property, $rawType, $value);
                $property->setAccessible(true);
                $property->setValue($this, $valueArray);
            } else {
                if ($propertyClass && is_array($value) && is_subclass_of($rawType, \ShipCore\DHLParcel\Entity\AbstractEntity::class)) {
                    $value = new $propertyClass($value);
                }
                if (!$this->checkType($this->getType($property), $value)) {
                    throw new \ShipCore\DHLParcel\Exception\InvalidTypeException(
                        get_class($this),
                        $property->getName(),
                        $this->getType($property)
                    );
                }
                $property->setAccessible(true);
                $property->setValue($this, $value);
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
        return ($reflectionClass->hasProperty($propertyName) && $this->canAccess($reflectionClass->getProperty($propertyName)));
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
