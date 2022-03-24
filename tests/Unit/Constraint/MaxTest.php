<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Max;
use UnexpectedValueException;

class MaxTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_ValueIsBellowMax()
    {
        $max = new Max(5);
        $input = 0;
        
        $result = $max->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_ValueIsEqualToMaxAndMaxIsIncludedByDefault()
    {
        $max = new Max(5);
        $input = 5;
        
        $result = $max->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_ValueIsEqualToMaxAndMaxIsIncluded()
    {
        $max = new Max(5);
        $max->includeMax();
        $input = 5;
        
        $result = $max->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ValueIsEqualToMaxAndMaxIsExcluded()
    {
        $max = new Max(5);
        $max->excludeMax();
        $input = 5;
        
        $result = $max->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ValueIsAboveMax()
    {
        $max = new Max(5);
        $input = 6;
        
        $result = $max->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_ValueIsInvalid()
    {
        $errorMessage = "Value is over max.";
        $max = new Max(5, $errorMessage);
        $input = 6;
        
        $result = $max->validate($input);
        
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ThrowException_When_ValueIsNotNumeric()
    {
        $this->expectException(UnexpectedValueException::class);
        
        $max = new Max(5);
        $max->validate(null);
    }
}
