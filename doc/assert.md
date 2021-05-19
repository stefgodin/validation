# Assert class
The Assert class is a container for every implemented validation and some mixins.

Here is a basic usage example:
```php
$value = 'This is right';
$valid = Assert::Length(1, 16)->validate($value);

if(!$valid){
    // The validation failed...
}

$errorMessage = Assert::Length(1, 16, 'Value is of the wrong length.')->validate($value);

if($errorMessage !== true){
    // The validation failed...
    echo $errorMessage; // Value is of the wrong length.
}
```

Some validations allow for more complex constructs such as associative arrays.
```php
$value = array(
    'foo' => 'hello',
    'bar' => 4
);
$valid = Assert::map([
    'foo' => Assert::Required(),
    'bar' => Assert::Range(0, 5)
])->validate($value);

if(!$valid){
    // The validation failed...
}
```

Here are some others:
```php

$value = 4;
$valid = Assert::AllOf([
    Assert::Required(),
    Assert::Numeric(),
    Assert::Range(0, 5)
])->validate($value);
// Every validation needs to succeed

if(!$valid){
    // The validation failed...
}
```
```php
$value = 23;
$valid = Assert::AnyOf([
    Assert::Numeric(),
    Assert::String()
])->validate($value);
// Only one validation needs to succeed

if(!$valid){
    // The validation failed...
}
```