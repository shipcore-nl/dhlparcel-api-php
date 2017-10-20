<?php
namespace ShipCore\DHLParcel\Entity;

class Address extends AbstractEntity
{
    
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Required()
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
    
    protected $addition;
    
    protected $postalCode;
    
    protected $city;
    
    protected $countryCode;
    
    protected $isBusiness;
}
