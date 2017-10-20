<?php
namespace ShipCore\DHLParcel\Entity;

class Label extends AbstractEntity
{
    protected $labelId;
    
    protected $labelType;
    
    protected $trackerCode;
    
    protected $routingCode;
    
    protected $userId;
    
    protected $organizationId;
    
    protected $orderReference;
    
    protected $pdf;
}
