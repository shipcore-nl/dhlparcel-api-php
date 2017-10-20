<?php
namespace ShipCore\DHLParcel\Entity;

class Token extends AbstractEntity
{
    protected $accessToken;
    
    protected $accessTokenExpiration;
    
    protected $refreshToken;
    
    protected $refreshTokenExpiration;
}
