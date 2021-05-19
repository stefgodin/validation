<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\MinLength;
use UnexpectedValueException;

class MinLengthTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_SingleByteStringLengthGreaterThanMin()
    {
        $minLength = new MinLength(3);
        $input = "Abcd";
        
        $result = $minLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_SingleByteStringLengthEqualToMin()
    {
        $minLength = new MinLength(3);
        $input = "Abc";
        
        $result = $minLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_SingleByteStringLengthLessThanMin()
    {
        $minLength = new MinLength(3);
        $input = "Ab";
        
        $result = $minLength->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_MultiByteStringLengthGreaterThanMin()
    {
        $minLength = new MinLength(3);
        $input = "ÉÈÔÎ";
        
        $result = $minLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_MultiByteStringLengthEqualToMin()
    {
        $minLength = new MinLength(3);
        $input = "ÉÈÔ";
        
        $result = $minLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_MultiByteStringLengthLessThanMin()
    {
        $minLength = new MinLength(3);
        $input = "ÉÈ";
        
        $result = $minLength->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_MultiByteStringLengthGreaterThanMinSingleByte()
    {
        $minLength = (new MinLength(3))->singleByte();
        $input = "AÉ"; // In single byte it should compare to 3
        
        $result = $minLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_Invalid()
    {
        $errorMessage = "Must be greater than or equal to 3.";
        $minLength = new MinLength(3, $errorMessage);
        $input = "Ab";
    
        $result = $minLength->validate($input);
    
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingSingleByteModifier()
    {
        $minLengthInstance = new MinLength(5);
        
        $sameInstance = $minLengthInstance->singleByte();
        
        $this->assertEquals($minLengthInstance, $sameInstance);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingMultiByteModifier()
    {
        $minLengthInstance = new MinLength(5);
        
        $sameInstance = $minLengthInstance->multiByte();
        
        $this->assertEquals($minLengthInstance, $sameInstance);
    }
    
    /** @test */
    public function Should_ThrowException_When_MinLengthIsLessThan0()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new MinLength(-1);
    }
    
    /** @test */
    public function Should_ThrowException_When_NonString()
    {
        $this->expectException(UnexpectedValueException::class);
        
        $minLength = new MinLength(3);
        
        $minLength->validate(1);
    }
}
