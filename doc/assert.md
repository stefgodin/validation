# Assert class
The Assert class is a container for every implemented validation and some mixins.

Here is a basic usage example:
```php
$report = Assert::length(1, 16)->validate('This is right');

if($report->isValid()){
    // The validation succeeded...
}
```

Some validations allow for more complex constructs such as associative arrays or forms.
```php
$report = Assert::map([
    'age' => Assert::allOf([
        Assert::required(),
        Assert::integer(),
        Assert::range(0, 128)
    ]),
    'name' => Assert::allOf([
        Assert::required(),
        Assert::string(),
        Assert::length(1, 50)
    ])
])->validate($_POST);

if($report->hasError()){
    foreach($report->getErrors() as $error){
        echo $error->getMessage(); // A descriptive message of the error
        echo $error->getPath(); // The property that contains this error
    }
}
```