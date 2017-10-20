<?php
namespace ShipCore\DHLParcel\Entity\Request;

use ShipCore\DHLParcel\Entity\AbstractEntity;

class AuthRequest extends AbstractEntity
{
    
    /**
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $userId;
    
    /**
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $key;
}
