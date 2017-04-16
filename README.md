[![Build Status](https://travis-ci.org/deseretdigital/knobby.svg?branch=master)](https://travis-ci.org/deseretdigital/knobby)

# knobby

Provides SDK for using feature flags.

## Flag Types

### Levers

A flag that passes its test if it's turned on.

```php
include('./vendor/autoload.php');

$config = array(
    array(
        'name' => 'exampleOn',
        'on' => true,
        'type' => 'lever',
    ),
    array(
        'name' => 'exampleOff',
        'on' => false,
        'type' => 'lever',
    ),
);

$knobby = new \DDM\Knobby\Knobby();
$knobby->loadConfigArray($config);

if ($knobby->test('exampleOn')) {
    /*
    feature code here will run as the lever is on
    */
}

if ($knobby->test('exampleOff')) {
    /*
    feature code here will not run as the lever is off
    */
}
```

### Knobs

A flag that passes its test if a test value is below the knob's value.

```php
include('./vendor/autoload.php');

$config = array(
    array(
        'name' => 'testKnob',
        'type' => 'knob',
        'value' => 15,
    ),
);

$knobby = new \DDM\Knobby\Knobby($config);

$userValue = 20;
if ($knobby->test('testKnob', $userValue)) {
    /*
    feature code here will not run, since the
    user value is greater than the allowed value
    */
}
```

Knobs can also be used to randomly generate a test value within a specified range
and then test this random value against the knob's value.

```php
include('./vendor/autoload.php');

$config = array(
    array(
        'name' => 'testKnob',
        'type' => 'knob',
        'min' => '10',
        'max' => '50',
        'value' => 15,
    ),
);

$knobby = new \DDM\Knobby\Knobby($config);

if ($knobby->test('testKnob')) {
    /*
    feature code here may or may not run depending on the value of the randomly
    generated test value between 10 and 50.
    */
}
```

TESTING AWESOMENESS
