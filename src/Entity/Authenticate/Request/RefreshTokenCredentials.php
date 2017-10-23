<?php
namespace ShipCore\DHLParcel\Entity\Authenticate\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class RefreshTokenCredentials extends DataObject
{
    /**
     * @Accessible()
     * @var string
     */
    protected $refreshToken;
}
