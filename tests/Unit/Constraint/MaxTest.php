<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Max;

class MaxTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_ValueIsBellowMax()
    {
        $max = new Max(5);
        $input = 0;
        
        $result = $max->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_ValueIsEqualToMaxAndMaxIsIncludedByDefault()
    {
        $max = new Max(5);
        $input = 5;
        
        $result = $max->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_ValueIsEqualToMaxAndMaxIsIncluded()
    {
        $max = new Max(5);
        $max->includeMax();
        $input = 5;
        
        $result = $max->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainTooHighError_When_ValueIsEqualToMaxAndMaxIsExcluded()
    {
        $max = new Max(5);
        $max->excludeMax();
        $input = 5;
        
        $result = $max->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Max::TOO_HIGH_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainTooHighError_When_ValueIsAboveMax()
    {
        $max = new Max(5);
        $input = 6;
        
        $result = $max->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Max::TOO_HIGH_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainNotANumberError_When_ValueIsNotNumeric()
    {
        $max = new Max(5);
        
        $result = $max->validate(null);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Max::NOT_A_NUMBER_ERROR, $error->getUuid());
        }
    }
}
