<?php
namespace ShipCore\DHLParcel\Entity;

class AbstractEntity extends \JsonSerializable
{
    public function jsonSerialize()
    {
    }
    
    public static function jsonDeserialize($data)
    {
    }
}
