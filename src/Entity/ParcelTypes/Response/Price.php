<?php
namespace ShipCore\DHLParcel\Entity\ParcelTypes\Response;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class Price extends DataObject
{
    /**
     *
     * @Accessible()
     * @var float
     */
    protected $withoutTax;

    /**
     *
     * @Accessible()
     * @var float
     */
    protected $withTax;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $currency;
}
