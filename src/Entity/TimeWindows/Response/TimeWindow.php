<?php
namespace ShipCore\DHLParcel\Entity\TimeWindows\Response;

use ShipCore\DataObject\DataObject;
use ShipCore\DataObject\Annotation\Accessible;

class TimeWindow extends DataObject
{
    /**
     *
     * @Accessible()
     * @var string
     */
    protected $postalCode;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $deliveryDate;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $type;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $startTime;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $endTime;

    /**
     *
     * @Accessible()
     * @var string
     */
    protected $status;
}
