<?php
namespace ShipCore\DHLParcel\Entity\Products\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class ProductQuery extends DataObject
{
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $fromCountry;

    /**
     *
     * @Accessible()
     * @var boolean
     */
    protected $businessProduct;
}
