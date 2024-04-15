<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Each;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;

class EachTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_EachElementIsValid()
    {
        $each = new Each(new ConstraintMock(true));
        
        $result = $each->validate(['', '', '']);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainError_When_OneElementIsInvalid()
    {
        $each = new Each(new ConstraintMock(false));
        
        $result = $each->validate(['']);
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_ContainInvalidArrayError_When_ValueIsNotTraversable()
    {
        $each = new Each(new ConstraintMock(true));
        
        $result = $each->validate('not an array');
        
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Each::INVALID_ARRAY_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainErrorMessages_When_Invalid()
    {
        $each = new Each(new ConstraintMock(false));
        
        $result = $each->validate(['', '']);
        
        foreach($result->getErrors() as $error) {
            $this->assertEquals(ConstraintMock::ERROR, $error->getUuid());
        }
        
        $this->assertCount(2, $result->getErrors());
    }
    
    /** @test */
    public function Should_MapSubErrorsWithKeyIndex_When_ConstraintIsFailing()
    {
        $map = new Each(new Each(new ConstraintMock(false)));
        
        $result = $map->validate([[null, null]]);
        
        $this->assertCount(2, $result->getErrors());
        foreach($result->getErrors() as $i => $error) {
            $this->assertEquals(ConstraintMock::ERROR, $error->getUuid());
            $this->assertEquals("[0][$i]", $error->getPath());
        }
    }
}
