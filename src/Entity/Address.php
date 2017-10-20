<?php
namespace ShipCore\DHLParcel\Entity;

class Address extends AbstractEntity
{
    
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $street;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $number;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $addition;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $postalCode;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $city;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $countryCode;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var boolean
     */
    protected $isBusiness;
}
