<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use ArrayIterator;
use InvalidArgumentException;
use Iterator;
use IteratorAggregate;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Type;

class TypeTest extends TestCase
{
    protected array $testValues;
    
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
            'traversable' => new class implements IteratorAggregate {
                
                public function getIterator(): Iterator
                {
                    return new ArrayIterator([]);
                }
            },
            'stringable_object' => new class() {
                public function __toString()
                {
                    return 'I\'m like a string';
                }
            },
            'object' => new class ( ) { },
        ];
    }
    
    private function assertInclude(Type $type, array $include, $assert)
    {
        $inputs = array_intersect_key($this->testValues, array_flip($include));
        foreach($inputs as $t => $value) {
            $this->assertEquals($assert, $type->validate($value)->isValid(), "Value of type {$t} did not meet expectations.");
        }
    }
    
    private function assertExclude(Type $type, array $exclude, $assert)
    {
        $inputs = array_diff_key($this->testValues, array_flip($exclude));
        foreach($inputs as $t => $value) {
            $this->assertEquals($assert, $type->validate($value)->isValid(), "Value of type {$t} did not meet expectations.");
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
    public function Should_ContainInvalidTypeError_When_Invalid()
    {
        $type = new Type(Type::STRING);
        
        $result = $type->validate($this->testValues['integer']);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Type::INVALID_TYPE_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ThrowException_When_GivenTypeInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Type('');
    }
}
