<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Min;
use UnexpectedValueException;

class MinTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_ValueIsAboveMin()
    {
        $min = new Min(0);
        $input = 1;
        
        $result = $min->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_ValueIsEqualToMinAndMinIsIncludedByDefault()
    {
        $min = new Min(0);
        $input = 0;
        
        $result = $min->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_ValueIsEqualToMinAndMinIsIncluded()
    {
        $min = new Min(0);
        $min->includeMin();
        $input = 0;
        
        $result = $min->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ValueIsEqualToMinAndMinIsExcluded()
    {
        $min = new Min(0);
        $min->excludeMin();
        $input = 0;
        
        $result = $min->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ValueIsBellowMin()
    {
        $min = new Min(0);
        $input = -1;
        
        $result = $min->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_ValueIsInvalid()
    {
        $errorMessage = "Value is bellow min.";
        $min = new Min(0, $errorMessage);
        $input = -1;
        
        $result = $min->validate($input);
        
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ThrowException_When_ValueIsNotNumeric()
    {
        $this->expectException(UnexpectedValueException::class);
        
        $min = new Min(0);
        $min->validate(null);
    }
}
