<?php
namespace ShipCore\DHLParcel\Entity;

class Contact extends AbstractEntity
{
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Required()
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $name;
    
    /**
     * @ShipCore\DHLParcel\Annotation\Required()
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var \ShipCore\DHLParcel\Entity\Address
     */
    protected $address;
    
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $email;
    
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $phoneNumber;
}
