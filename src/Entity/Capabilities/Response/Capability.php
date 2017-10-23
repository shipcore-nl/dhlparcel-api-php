<?php
namespace ShipCore\DHLParcel\Entity\Capabilities\Response;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;
use ShipCore\DHLParcel\Entity\Products\Response\Product;
use ShipCore\DHLParcel\Entity\ParcelTypes\Response\ParcelType;

class Capability extends DataObject
{
    /**
     *
     * @Accessible()
     * @var integer
     */
    protected $rank;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $fromCountryCode;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $toCountryCode;

    /**
     *
     * @Accessible()
     * @var Product
     */
    protected $product;

    /**
     *
     * @Accessible()
     * @var ParcelType
     */
    protected $parcelType;

    /**
     *
     * @Accessible()
     * @var \ShipCore\DHLParcel\Entity\ShipmentOptions\Response\ShipmentOption[]
     */
    protected $options;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $returnUrl;
}
