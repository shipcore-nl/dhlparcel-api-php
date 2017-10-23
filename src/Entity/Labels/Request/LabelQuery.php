<?php
namespace ShipCore\DHLParcel\Entity\Labels\Request;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class LabelQuery extends DataObject
{
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $trackerCodeFilter;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $orderReferenceFilter;
}
