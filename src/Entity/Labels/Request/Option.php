<?php
namespace ShipCore\DHLParcel\Entity\Labels\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class Option extends DataObject
{
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $key;
    
     /**
     *
     * @Accessible()
     * @var string
     */
    protected $input;
}
