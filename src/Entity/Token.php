<?php
namespace ShipCore\DHLParcel\Entity;

class Token extends AbstractEntity
{
    /**
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $accessToken;
    
    /**
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var integer
     */
    protected $accessTokenExpiration;
    
    /**
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $refreshToken;
    
    /**
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var integer
     */
    protected $refreshTokenExpiration;
}
