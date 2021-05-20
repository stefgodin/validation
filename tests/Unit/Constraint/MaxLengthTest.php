<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\MaxLength;
use UnexpectedValueException;

class MaxLengthTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_EmptyString()
    {
        $maxLength = new MaxLength(5);
        $input = "";
        
        $result = $maxLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_SingleByteStringLengthLessThanMax()
    {
        $maxLength = new MaxLength(5);
        $input = "Abcd";
        
        $result = $maxLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_SingleByteStringLengthEqualToMax()
    {
        $maxLength = new MaxLength(5);
        $input = "Abcde";
        
        $result = $maxLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_SingleByteStringLengthMoreThanMax()
    {
        $maxLength = new MaxLength(5);
        $input = "AbcdeF";
        
        $result = $maxLength->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_MultiByteStringLengthLessThanMax()
    {
        $maxLength = new MaxLength(5);
        $input = "ÉÈÔÎ";
        
        $result = $maxLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_MultiByteStringLengthEqualToMax()
    {
        $maxLength = new MaxLength(5);
        $input = "ÉÈÔÎï";
        
        $result = $maxLength->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_MultiByteStringLengthMoreThanMax()
    {
        $maxLength = new MaxLength(5);
        $input = "ÉÈÔÎïÀ";
        
        $result = $maxLength->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_MultiByteStringLengthMoreThanMaxSingleByte()
    {
        $maxLength = (new MaxLength(5))->singleByte();
        $input = "AbcdÉ";
        
        $result = $maxLength->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_Invalid()
    {
        $errorMessage = "Must be less than or equal to 5.";
        $maxLength = new MaxLength(5, $errorMessage);
        $input = "AbcdeF";
    
        $result = $maxLength->validate($input);
    
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingSingleByteModifier()
    {
        $maxLengthInstance = new MaxLength(5);
        
        $sameInstance = $maxLengthInstance->singleByte();
        
        $this->assertEquals($maxLengthInstance, $sameInstance);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingMultiByteModifier()
    {
        $maxLengthInstance = new MaxLength(5);
        
        $sameInstance = $maxLengthInstance->multiByte();
        
        $this->assertEquals($maxLengthInstance, $sameInstance);
    }
    
    /** @test */
    public function Should_ThrowException_When_MaxLengthIsLessThan0()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new MaxLength(-1);
    }
    
    /** @test */
    public function Should_ThrowException_When_NonString()
    {
        $this->expectException(UnexpectedValueException::class);
        
        $maxLength = new MaxLength(5);
        
        $maxLength->validate(1);
    }
}
