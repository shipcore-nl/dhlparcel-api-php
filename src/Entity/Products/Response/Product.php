<?php
namespace ShipCore\DHLParcel\Entity\Products\Response;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class Product extends DataObject
{
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $key;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $label;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $code;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $menuCode;

    /**
     *
     * @Accessible()
     * @var boolean
     */
    protected $businessProduct;
    
    /**
     *
     * @Accessible()
     * @var boolean
     */
    protected $monoColloProduct;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $softwareCharacteristic;
    
    /**
     *
     * @Accessible()
     * @var boolean
     */
    protected $returnProduct;
}
