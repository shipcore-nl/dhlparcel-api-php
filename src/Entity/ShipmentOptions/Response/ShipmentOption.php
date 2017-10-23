<?php
namespace ShipCore\DHLParcel\Entity\ShipmentOptions\Response;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;
use ShipCore\DataObject\Annotation\Required;

class ShipmentOption extends DataObject
{
    /**
     * @Accessible()
     * @Required()
     * @var string
     */
    protected $key;

    /**
     * @Accessible()
     * @var integer
     */
    protected $rank;

    /**
     * @Accessible()
     * @var integer
     */
    protected $code;

    /**
     * @Accessible()
     * @var Price
     */
    protected $price;
    
    /**
     * @Accessible()
     * @var string
     */
    protected $inputType;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $inputMin;
    
    /**
     * @Accessible()
     * @var string
     */
    protected $inputMax;
    
    /**
     * @Accessible()
     * @var string
     */
    protected $description;

    /**
     * @Accessible()
     * @var \ShipCore\DHLParcel\Entity\ShipmentOptions\Response\ShipmentOption[]
     */
    protected $exclusions;
}
