<?php
namespace ShipCore\DHLParcel\Entity\Request;

class AuthRefreshRequest extends AbstractEntity
{
    /**
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var \ShipCore\DHLParcel\Entity\Token
     */
    protected $refreshToken;
}
