<?php
namespace ShipCore\DHLParcel\Entity;

class Name extends AbstractEntity
{
    
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $firstName;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $lastName;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $companyName;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $additionalName;
}
