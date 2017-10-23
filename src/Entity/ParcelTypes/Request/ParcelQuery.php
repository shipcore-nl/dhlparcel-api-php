<?php
namespace ShipCore\DHLParcel\Entity\ParcelTypes\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class ParcelQuery extends DataObject
{
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $toCountry;

    /**
     *
     * @Accessible()
     * @var boolean
     */
    protected $toBusiness;
}
