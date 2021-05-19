<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Optional;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;

class OptionalTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_ValueIsNull()
    {
        $optional = new Optional(new ConstraintMock(true));
        $input = null;
        
        $result = $optional->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_ValueIsNotNullAndConstraintIsValid()
    {
        $optional = new Optional(new ConstraintMock(true));
        $input = true;
    
        $result = $optional->validate($input);
    
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ValueIsNotNullAndConstraintIsInvalid()
    {
        $optional = new Optional(new ConstraintMock(true));
        $input = false;
    
        $result = $optional->validate($input);
    
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnConstraintMessage_When_ValueIsInvalid()
    {
        $errorMessage = 'Value is not true.';
        $optional = new Optional(new ConstraintMock(true, $errorMessage));
        $input = false;
    
        $result = $optional->validate($input);
    
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_ValueIsInvalid()
    {
        $errorMessage = 'Value is invalid.';
        $optional = new Optional(new ConstraintMock(true, 'This value is not true.'), $errorMessage);
        $input = false;
    
        $result = $optional->validate($input);
    
        $this->assertEquals($errorMessage, $result);
    }
}
