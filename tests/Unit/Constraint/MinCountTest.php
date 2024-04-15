<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\MinCount;

class MinCountTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_CountIsGreaterThanMin()
    {
        $minCount = new MinCount(0);
        $input = [1];
        
        $result = $minCount->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_CountIsEqualToMin()
    {
        $minCount = new MinCount(0);
        $input = [];
        
        $result = $minCount->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainTooFewError_When_CountIsLessThanMin()
    {
        $minCount = new MinCount(1);
        $input = [];
        
        $result = $minCount->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MinCount::TOO_FEW_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ThrowException_When_MinIsLessThan0()
    {
        $this->expectException(InvalidArgumentException::class);
        new MinCount(-1);
    }
    
    /** @test */
    public function Should_ContainInvalidArrayError_When_ValueIsNotCountable()
    {
        $minCount = new MinCount(0);
        
        $result = $minCount->validate(null);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MinCount::INVALID_ARRAY_ERROR, $error->getUuid());
        }
    }
}
