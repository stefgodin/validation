<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\MaxCount;

class MaxCountTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_CountIsLessThanMax()
    {
        $maxCount = new MaxCount(3);
        
        $result = $maxCount->validate([1]);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_CountIsEqualToMax()
    {
        $maxCount = new MaxCount(3);
        $input = [1, 1, 1];
        
        $result = $maxCount->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ReturnFalse_When_CountIsGreaterThanMax()
    {
        $maxCount = new MaxCount(3);
        $input = [1, 1, 1, 1];
        
        $result = $maxCount->validate($input);
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_ContainTooManyError_When_CountIsInvalid()
    {
        $maxCount = new MaxCount(3);
        $input = [1, 1, 1, 1];
        
        $result = $maxCount->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MaxCount::TOO_MANY_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ThrowException_When_MaxIsLessThan0()
    {
        $this->expectException(InvalidArgumentException::class);
        new MaxCount(-1);
    }
    
    /** @test */
    public function Should_ContainInvalidArrayError_When_ValueIsNotCountable()
    {
        $maxCount = new MaxCount(1);
        
        $result = $maxCount->validate(null);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MaxCount::INVALID_ARRAY_ERROR, $error->getUuid());
        }
    }
}
