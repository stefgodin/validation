# Assert class
The Assert class is a container for every implemented validation.

Here is a basic usage example:
```php
$value = 'This is right';
$errors = Assert::Length(1, 16)->validate($value);

if($errors->any()){
    // The validation failed...
}
```

Some validations allow for more complex constructs such as associative arrays.
```php
$value = array(
    'foo' => 'hello'
    'bar' => 4
);
$errors = Assert::map([
    'foo' => Assert::Required(),
    'bar' => Assert::Range(0, 5)
])->validate($value);

if($errors->any()){
    // The validation failed...
}
```

The ::map validation is an example of combined validations.

Here are some others:
```php

$value = 4;
$errors = Assert::AllOf([
    Assert::Required(),
    Assert::Numeric(),
    Assert::Range(0, 5)
])->validate($value);
// Every validation needs to succeed

if($errors->any()){
    // The validation failed...
}
```
```php
$value = 23;
$errors = Assert::OneOf([
    Assert::Numeric(),
    Assert::String()
])->validate($value);
// Only one validation needs to succeed

if($errors->any()){
    // The validation failed...
}
```