<?php
namespace ShipCore\DHLParcel\Entity\Request;

use ShipCore\DHLParcel\Entity\AbstractEntity;

class CreateLabelRequest extends AbstractEntity
{
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $labelId;
    
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $orderReference;
    
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Required()
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $parcelTypeKey;
    
    /**
     * @ShipCore\DHLParcel\Annotation\Required()
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var \ShipCore\DHLParcel\Entity\Contact
     */
    protected $receiver;
    
    /**
     * @ShipCore\DHLParcel\Annotation\Required()
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var \ShipCore\DHLParcel\Entity\Contact
     */
    protected $shipper;
    
    /**
     * @ShipCore\DHLParcel\Annotation\Required()
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var string
     */
    protected $accountId;
    
    /**
     * @ShipCore\DHLParcel\Annotation\Required()
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var mixed[]
     */
    protected $options;
    
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var boolean
     */
    protected $returnLabel;
    
    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var integer
     */
    protected $pieceNumber;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var integer
     */
    protected $quantity;

    /**
     *
     * @ShipCore\DHLParcel\Annotation\Accessible()
     * @var boolean
     */
    protected $automaticPrintDialog;
}
