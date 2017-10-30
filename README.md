# DHL Parcel API PHP Bindings

PHP Library to use DHL Parcel API as documented on https://api-gw.dhlparcel.nl/docs/.

## Install instructions

```
composer require shipcore-nl/dhlparcel-api-php
```

## Example

### Create Shipment Label

```
$userId = 'YOUR_USER_ID'
$key = 'YOUR_KEY';
$sandbox = true;

$dhl = new \ShipCore\DHLParcel\Api($userId, $key, null, $sandbox);

$labelSpecification = \ShipCore\DHLParcel\Entity\Request\LabelSpecification::fromDataArray([
    'labelId' => ShipCore\DHLParcel\Util\UUID::generateUUID(),
    'orderReference' => 'myReference',
    'parcelTypeKey' => 'SMALL',
    'receiver' => [
        'name'  => [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'companyName' => 'ACME Corp.',
            'additionalName' => 'Benelux'
        ],
        'address' => [
            'countryCode' => 'NL',
            'postalCode' => '3542AD',
            'city' => 'Utrecht',
            'street' => 'Reactorweg',
            'number' => '25',
            'isBusiness' => true,
            'addition' => 'A'
        ],
        'email' => 'mrparcel@dhlparcel.nl',
        'phoneNumber' => '0031612345678'
    ],
    'shipper' => [
        'name'  => [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'companyName' => 'ACME Corp.',
            'additionalName' => 'Benelux'
        ],
        'address' => [
            'countryCode' => 'NL',
            'postalCode' => '3542AD',
            'city' => 'Utrecht',
            'street' => 'Reactorweg',
            'number' => '25',
            'isBusiness' => true,
            'addition' => 'A'
        ],
        'email' => 'mrparcel@dhlparcel.nl',
        'phoneNumber' => '0031612345678'
    ],
    'accountId' => '01234567',
    'options' => [
        [
        'key' => 'DOOR'
        ]
     ],
    'returnLabel' => false,
    'pieceNumber' => 1,
    'quantity' => 1,
    'automaticPrintDialog' => true
]);

$response = $dhl->createLabel($labelSpecification);
print_r($response);

```
