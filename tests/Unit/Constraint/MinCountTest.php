<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\MinCount;
use UnexpectedValueException;

class MinCountTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_CountIsGreaterThanMin()
    {
        $minCount = new MinCount(0);
        $input = array(1);
        
        $result = $minCount->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_CountIsEqualToMin()
    {
        $minCount = new MinCount(0);
        $input = array();
        
        $result = $minCount->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_CountIsLessThanMin()
    {
        $minCount = new MinCount(1);
        $input = array();
        
        $result = $minCount->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_CountIsInvalid()
    {
        $errorMessage = "Count is too big.";
        $minCount = new MinCount(1, $errorMessage);
        $input = array();
    
        $result = $minCount->validate($input);
    
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ThrowException_When_MinIsLessThan0()
    {
        $this->expectException(InvalidArgumentException::class);
        new MinCount(-1);
    }
    
    /** @test */
    public function Should_ThrowException_When_ValueIsNotCountable()
    {
        $this->expectException(UnexpectedValueException::class);
        $minCount = new MinCount(0);
        $minCount->validate(null);
    }
}
