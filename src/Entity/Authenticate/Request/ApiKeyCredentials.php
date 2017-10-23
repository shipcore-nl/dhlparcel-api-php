<?php
namespace ShipCore\DHLParcel\Entity\Authenticate\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class ApiKeyCredentials extends DataObject
{
    
    /**
     * @Accessible()
     * @var string
     */
    protected $userId;
    
    /**
     * @Accessible()
     * @var string
     */
    protected $key;
}
