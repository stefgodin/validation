<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Min;

class MinTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_ValueIsAboveMin()
    {
        $min = new Min(0);
        $input = 1;
        
        $result = $min->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_ValueIsEqualToMinAndMinIsIncludedByDefault()
    {
        $min = new Min(0);
        $input = 0;
        
        $result = $min->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_ValueIsEqualToMinAndMinIsIncluded()
    {
        $min = new Min(0);
        $min->includeMin();
        $input = 0;
        
        $result = $min->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainTooLowError_When_ValueIsEqualToMinAndMinIsExcluded()
    {
        $min = new Min(0);
        $min->excludeMin();
        $input = 0;
        
        $result = $min->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Min::TOO_LOW_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainTooLowError_When_ValueIsBellowMin()
    {
        $min = new Min(0);
        $input = -1;
        
        $result = $min->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Min::TOO_LOW_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainNotANumberError_When_ValueIsNotNumeric()
    {
        $min = new Min(0);
        $result = $min->validate(null);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Min::NOT_A_NUMBER_ERROR, $error->getUuid());
        }
    }
}
