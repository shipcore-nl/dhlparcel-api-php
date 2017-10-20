<?php
namespace ShipCore\DHLParcel\Entity;

class Address extends AbstractEntity
{
    protected $street;
    
    protected $number;
    
    protected $addition;
    
    protected $postalCode;
    
    protected $city;
    
    protected $countryCode;
    
    protected $isBusiness;
}
