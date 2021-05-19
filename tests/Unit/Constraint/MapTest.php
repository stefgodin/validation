<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Map;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;
use UnexpectedValueException;

class MapTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_EveryElementIsValid()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
            'two' => new ConstraintMock(true),
        ]);
        $input = [
            'one' => true,
            'two' => true,
        ];
        
        $result = $map->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_AnyElementIsInvalid()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
            'two' => new ConstraintMock(true),
        ]);
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_AnyMissingElementIsValidOnNull()
    {
        $map = new Map([
            'one' => new ConstraintMock(null)
        ]);
        
        $input = [];
        
        $result = $map->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_AnyMissingElementIsInvalidOnNull()
    {
        $map = new Map([
            'one' => new ConstraintMock(true)
        ]);
        
        $input = [];
        
        $result = $map->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_AnyElementIsInvalid()
    {
        $errorMessage = "Two is not true.";
        $map = new Map([
            'one' => new ConstraintMock(true),
            'two' => new ConstraintMock(true, $errorMessage),
        ]);
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ReturnSpaceConcatenatedMessages_When_ManyElementsAreInvalid()
    {
        $oneErrorMessage = "One is not true.";
        $twoErrorMessage = "Two is not true.";
        $map = new Map([
            'one' => new ConstraintMock(true, $oneErrorMessage),
            'two' => new ConstraintMock(true, $twoErrorMessage),
        ]);
        
        $input = [
            'one' => false,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertEquals("{$oneErrorMessage} {$twoErrorMessage}", $result);
    }
    
    /** @test */
    public function Should_ReturnMainMessages_When_AnyElementsIsInvalid()
    {
        $errorMessage = "The collection is invalid.";
        $map = new Map([
            'one' => new ConstraintMock(true),
            'two' => new ConstraintMock(true),
        ], $errorMessage);
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ExtraFieldsAreDisabledByDefault()
    {
        $map = new Map([
            'one' => new ConstraintMock(true)
        ]);
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ExtraFieldsAreDisabled()
    {
        $map = new Map([
            'one' => new ConstraintMock(true)
        ]);
        $map->disallowExtra();
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_ExtraFieldsAreAllowed()
    {
        $map = new Map([
            'one' => new ConstraintMock(true)
        ]);
        $map->allowExtra();
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_ExtraFieldsAreAllowedAndNoConstrainsGiven()
    {
        $map = new Map([]);
        $map->allowExtra();
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingAllowExtraModifier()
    {
        $instance = new Map(['one' => new ConstraintMock(true)]);
        
        $sameInstance = $instance->allowExtra();
        
        $this->assertEquals($instance, $sameInstance);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingDisallowExtraModifier()
    {
        $instance = new Map(['one' => new ConstraintMock(true)]);
        
        $sameInstance = $instance->disallowExtra();
        
        $this->assertEquals($instance, $sameInstance);
    }
    
    /** @test */
    public function Should_ThrowException_When_ValueIsNotTraversable()
    {
        $this->expectException(UnexpectedValueException::class);
        $map = new Map([
            'one' => new ConstraintMock(true)
        ]);
        
        $input = null;
        
        $map->validate($input);
    }
    
    /** @test */
    public function Should_ThrowException_When_NonConstraintIsGiven()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Map(['stuff' => 1]);
    }
}
