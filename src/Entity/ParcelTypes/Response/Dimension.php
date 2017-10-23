<?php
namespace ShipCore\DHLParcel\Entity\ParcelTypes\Response;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class Dimension extends DataObject
{
    /**
     *
     * @Accessible()
     * @var integer
     */
    protected $maxLengthCm;

    /**
     *
     * @Accessible()
     * @var integer
     */
    protected $maxWidthCm;

    /**
     *
     * @Accessible()
     * @var integer
     */
    protected $maxHeightCm;
}
