<?php
namespace ShipCore\DHLParcel\Entity\Capabilities\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;
use ShipCore\DataObject\Annotation\Required;

class CapabilityQuery extends DataObject
{
    /**
     * @Accessible()
     * @Required()
     * @var string
     */
    protected $fromCountry;
    
    /**
     * @Accessible()
     * @Required()
     * @var string
     */
    protected $toCountry;

    /**
     * @Accessible()
     * @var boolean
     */
    protected $toBusiness;
    
    /**
     * @Accessible()
     * @var boolean
     */
    protected $returnProduct;
    
    /**
     * @Accessible()
     * @var string
     */
    protected $parcelType;
    
    /**
     * @Accessible()
     * @var string[]
     */
    protected $options;
    
    /**
     * @Accessible()
     * @var string
     */
    protected $toPostalCode;
    
    /**
     * @Accessible()
     * @var string
     */
    protected $accountNumber;

    /**
     * @Accessible()
     * @var string
     */
    protected $organisationId;
}
