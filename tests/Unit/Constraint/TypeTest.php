<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;


use InvalidArgumentException;
use IteratorAggregate;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Type;

class TypeTest extends TestCase
{
    protected $testValues;
    
    protected function setUp(): void
    {
        $this->testValues = [
            'null' => null,
            'bool' => true,
            'string' => 'I\'m a string',
            'integer' => 1,
            'float' => 1.5,
            'numeric_string' => '1.5',
            'array' => [],
            'traversable' => new class implements IteratorAggregate{
                
                public function getIterator()
                {
                    return [];
                }
            },
            'stringable_object' => new class(){
                public function __toString()
                {
                    return 'I\'m like a string';
                }
            },
            'object' => new class(){}
        ];
    }
    
    private function assertInclude(Type $_type, array $_include, $_assert)
    {
        $inputs = array_intersect_key($this->testValues, array_flip($_include));
        foreach ($inputs as $type => $value){
            $this->assertEquals($_assert, $_type->validate($value), "Value of type {$type} did not meet expectations.");
        }
    }
    
    private function assertExclude(Type $_type, array $_exclude, $_assert)
    {
        $inputs = array_diff_key($this->testValues, array_flip($_exclude));
        foreach ($inputs as $type => $value){
            $this->assertEquals($_assert, $_type->validate($value), "Value of type {$type} did not meet expectations.");
        }
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsBooleanWithBooleanValue()
    {
        $type = new Type(Type::BOOLEAN);
        $this->assertInclude($type, ['bool'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsBooleanWithNonBooleanValue()
    {
        $type = new Type(Type::BOOLEAN);
        $this->assertExclude($type, ['bool'], false);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsStringWithStringValue()
    {
        $type = new Type(Type::STRING);
        $this->assertInclude($type, ['string', 'numeric_string'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsStringWithNonStringValue()
    {
        $type = new Type(Type::STRING);
        $this->assertExclude($type, ['string', 'numeric_string'], false);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsStringableWithStringableValue()
    {
        $type = new Type(Type::STRINGABLE);
        $this->assertInclude($type, ['null', 'bool', 'string', 'integer', 'float', 'numeric_string', 'stringable_object'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsStringableWithNonStringableValue()
    {
        $type = new Type(Type::STRINGABLE);
        $this->assertExclude($type, ['null', 'bool', 'string', 'integer', 'float', 'numeric_string', 'stringable_object'], false);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsIntegerWithIntegerValue()
    {
        $type = new Type(Type::INTEGER);
        $this->assertInclude($type, ['integer'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsIntegerWithNonIntegerValue()
    {
        $type = new Type(Type::INTEGER);
        $this->assertExclude($type, ['integer'], false);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsDoubleWithDoubleValue()
    {
        $type = new Type(Type::DOUBLE);
        $this->assertInclude($type, ['float'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsDoubleWithNonDoubleValue()
    {
        $type = new Type(Type::DOUBLE);
        $this->assertExclude($type, ['float'], false);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsFloatWithFloatValue()
    {
        $type = new Type(Type::FLOAT);
        $this->assertInclude($type, ['float'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsFloatWithNonFloatValue()
    {
        $type = new Type(Type::FLOAT);
        $this->assertExclude($type, ['float'], false);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsNumericWithNumericValue()
    {
        $type = new Type(Type::NUMERIC);
        $this->assertInclude($type, ['integer', 'float', 'numeric_string'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsNumericWithNonNumericValue()
    {
        $type = new Type(Type::NUMERIC);
        $this->assertExclude($type, ['integer', 'float', 'numeric_string'], false);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsArrayWithArrayValue()
    {
        $type = new Type(Type::ARRAY);
        $this->assertInclude($type, ['array'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsArrayWithNonArrayValue()
    {
        $type = new Type(Type::ARRAY);
        $this->assertExclude($type, ['array'], false);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsScalarWithScalarValue()
    {
        $type = new Type(Type::SCALAR);
        $this->assertInclude($type, ['bool', 'string', 'integer', 'float', 'numeric_string'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsScalarWithNonScalarValue()
    {
        $type = new Type(Type::SCALAR);
        $this->assertExclude($type, ['bool', 'string', 'integer', 'float', 'numeric_string'], false);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_TypeIsTraversableWithTraversableValue()
    {
        $type = new Type(Type::TRAVERSABLE);
        $this->assertInclude($type, ['array', 'traversable'], true);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_TypeIsTraversableWithNonTraversableValue()
    {
        $type = new Type(Type::TRAVERSABLE);
        $this->assertExclude($type, ['array', 'traversable'], false);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_Invalid()
    {
        $message = "The value must be a string";
        $type = new Type(Type::STRING, $message);
        
        $result = $type->validate($this->testValues['integer']);
        
        $this->assertEquals($message, $result);
    }
    
    /** @test */
    public function Should_ThrowException_When_GivenTypeInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Type('');
    }
}
