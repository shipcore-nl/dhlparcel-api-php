<?php
namespace ShipCore\DHLParcel\Entity\ParcelTypes\Response;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class ParcelType extends DataObject
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
     * @var integer
     */
    protected $minWeightKg;

    /**
     *
     * @Accessible()
     * @var integer
     */
    protected $maxWeightKg;

    /**
     *
     * @Accessible()
     * @var Dimension
     */
    protected $dimensions;

    /**
     *
     * @Accessible()
     * @var Price
     */
    protected $price;
}
