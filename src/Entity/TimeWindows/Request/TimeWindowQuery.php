<?php
namespace ShipCore\DHLParcel\Entity\TimeWindows\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class TimeWindowQuery extends DataObject
{
    /**
     * @Accessible()
     * @var string
     */
    protected $countryCode;
    
    /**
     * @Accessible()
     * @var string
     */
    protected $postalCode;
}
