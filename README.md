knobby
======

Provides SDK for using feature flags and knobs

Basic Usage

```php
$config = array(
    array(
        'name' => 'testKnob',
        'type' => 'knob',
        'min' => 10,
        'max' => 50,
        'value' => 15,    
    ),
    array(
        'name' => 'testLever',
        'on' => false,
        'type' => 'lever',
    ),
)}
$knobby = new \DDM\Knobby\Knobby($config);

if($knobby->test('testLever')){
	/*
	feature code here will run
	 */
}

$userValue = 20;
if($knobby->test('testKnob',$userValue)){
	/*
	feature code here will not run, since the
	user value is greater than the allowed threshold
	 */
}
```