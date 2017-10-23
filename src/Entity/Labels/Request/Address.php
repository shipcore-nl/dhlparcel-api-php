<?php
namespace ShipCore\DHLParcel\Entity\Labels\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class Address extends DataObject
{
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $street;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $number;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $addition;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $postalCode;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $city;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $countryCode;

    /**
     *
     * @Accessible()
     * @var boolean
     */
    protected $isBusiness;
}
