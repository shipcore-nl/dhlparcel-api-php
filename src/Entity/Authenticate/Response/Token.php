<?php
namespace ShipCore\DHLParcel\Entity\Authenticate\Response;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class Token extends DataObject
{
    /**
     * @Accessible()
     * @var string
     */
    protected $accessToken;
    
    /**
     * @Accessible()
     * @var integer
     */
    protected $accessTokenExpiration;
    
    /**
     * @Accessible()
     * @var string
     */
    protected $refreshToken;
    
    /**
     * @Accessible()
     * @var integer
     */
    protected $refreshTokenExpiration;
}
