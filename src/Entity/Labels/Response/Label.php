<?php
namespace ShipCore\DHLParcel\Entity\Labels\Response;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class Label extends DataObject
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
    protected $labelType;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $trackerCode;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $routingCode;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $userId;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $organizationId;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $orderReference;
    
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $pdf;
}
