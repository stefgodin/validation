<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\MaxCount;
use UnexpectedValueException;

class MaxCountTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_CountIsLessThanMax()
    {
        $maxCount = new MaxCount(3);
        $input = array(1);
        
        $result = $maxCount->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_CountIsEqualToMax()
    {
        $maxCount = new MaxCount(3);
        $input = array(1, 1, 1);
        
        $result = $maxCount->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_CountIsGreaterThanMax()
    {
        $maxCount = new MaxCount(3);
        $input = array(1, 1, 1, 1);
        
        $result = $maxCount->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_CountIsInvalid()
    {
        $errorMessage = "Count is too big.";
        $maxCount = new MaxCount(3, $errorMessage);
        $input = array(1, 1, 1, 1);
    
        $result = $maxCount->validate($input);
    
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ThrowException_When_MaxIsLessThan0()
    {
        $this->expectException(InvalidArgumentException::class);
        new MaxCount(-1);
    }
    
    /** @test */
    public function Should_ThrowException_When_ValueIsNotCountable()
    {
        $this->expectException(UnexpectedValueException::class);
        $maxCount = new MaxCount(1);
        $maxCount->validate(null);
    }
}
