<?php
namespace ShipCore\DHLParcel\Entity\Labels\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;
use ShipCore\DataObject\Annotation\Required;

class LabelSpecification extends DataObject
{
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $labelId;
    
     /**
     *
     * @Accessible()
     * @var string
     */
    protected $labelFormat;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $orderReference;
    
    /**
     *
     * @Required()
     * @Accessible()
     * @var string
     */
    protected $parcelTypeKey;
    
    /**
     * @Required()
     * @Accessible()
     * @var Contact
     */
    protected $receiver;
    
    /**
     * @Required()
     * @Accessible()
     * @var Contact
     */
    protected $shipper;
    
    /**
     * @Required()
     * @Accessible()
     * @var string
     */
    protected $accountId;
    
    /**
     * @Required()
     * @Accessible()
     * @var \ShipCore\DHLParcel\Entity\Labels\Request\Option[]
     */
    protected $options;
    
    /**
     *
     * @Accessible()
     * @var boolean
     */
    protected $returnLabel;
    
    /**
     *
     * @Accessible()
     * @var integer
     */
    protected $pieceNumber;

    /**
     *
     * @Accessible()
     * @var integer
     */
    protected $quantity;

    /**
     *
     * @Accessible()
     * @var boolean
     */
    protected $automaticPrintDialog;
}
