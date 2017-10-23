<?php
namespace ShipCore\DHLParcel\Entity\Labels\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;
use ShipCore\DataObject\Annotation\Required;

class Contact extends DataObject
{
    /**
     *
     * @Required()
     * @Accessible()
     * @var Name
     */
    protected $name;
    
    /**
     * @Required()
     * @Accessible()
     * @var Address
     */
    protected $address;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $email;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $phoneNumber;
}
