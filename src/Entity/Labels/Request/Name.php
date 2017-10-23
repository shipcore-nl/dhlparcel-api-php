<?php
namespace ShipCore\DHLParcel\Entity\Labels\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class Name extends DataObject
{
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $firstName;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $lastName;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $companyName;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $additionalName;
}
