<?php
namespace ShipCore\DHLParcel\Entity\Request;

class CreateLabelRequest extends AbstractEntity
{
    protected $labelId;
    
    protected $orderReference;
    
    protected $parcelTypeKey;
    
    // Contact
    protected $receiver;
    
    // Contact
    protected $shipper;
    
    protected $accountId;
    
    // array of string
    protected $options;
    
    protected $returnLabel;
    
    protected $pieceNumber;
    
    protected $quantity;
    
    protected $automaticPrintDialog;
}
