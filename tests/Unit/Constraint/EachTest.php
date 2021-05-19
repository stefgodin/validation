<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Each;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;
use UnexpectedValueException;

class EachTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_EachElementIsValid()
    {
        $each = new Each(new ConstraintMock(true));
        
        $result = $each->validate([true, true, true, true]);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_OneElementIsInvalid()
    {
        $each = new Each(new ConstraintMock(true));
        
        $result = $each->validate([true, true, true, false]);
    
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ThrowException_When_ValueIsNotTraversable()
    {
        $this->expectException(UnexpectedValueException::class);
        $each = new Each(new ConstraintMock(true));
        
        $each->validate('not an array');
    }
    
    /** @test */
    public function Should_ReturnMessage_When_Invalid()
    {
        $errorMessage = 'Some elements in the list are invalid.';
        $each = new Each(new ConstraintMock(true), $errorMessage);
        
        $result = $each->validate([true, true, true, false]);
        
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ReturnConstraintMessage_When_Invalid()
    {
        $errorMessage = 'This element is not true.';
        $each = new Each(new ConstraintMock(true, $errorMessage));
        
        $result = $each->validate([true, true, true, false]);
        
        $this->assertEquals($errorMessage, $result);
    }
}
